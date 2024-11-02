<?php
require('../requires.php');


$config = require(base_path('configs.php'));
$db = new Database($config['Database']);

$data = json_decode(file_get_contents('php://input'), true);



// get the order details
$order = $db->query('SELECT * FROM order_tbl JOIN flavor_tbl ON order_tbl.flavor_id = flavor_tbl.flavor_id WHERE order_tbl.order_id = :order_id', [
    'order_id' => $data['order_id']
])->fetch();


$ingredients_needed = $db->query('SELECT ingredient_tbl.ingredient_id, ingredient_tbl.ingredient_name, ingredient_tbl.ingredient_price, order_tbl.order_size / 4 * ingredient_tbl.ingredient_usage_per_4_gallons AS "ingredients_needed" FROM order_tbl, ingredient_tbl WHERE order_tbl.order_id = :id', [
    'id' => $order['order_id']
])->fetchAll();

foreach ($ingredients_needed as $ingredient) {
    
    // record each ingredient cost on transaction_tbl
    $db->query('INSERT INTO transaction_tbl (expense_amount, transaction_type, transaction_datetime, ingredient_id, order_id, ingredient_quantity, ingredient_price_per_unit, transaction_info) VALUES (:amount, :type, :datetime, :iid, :oid, :quantity, :price_per_unit, :info)', [
        'amount' => $ingredient['ingredients_needed'] * $ingredient['ingredient_price'],
        'type' => 'EXPENSE',
        'datetime' => date('Y-m-d H:i:s'),
        'iid' => $ingredient['ingredient_id'],
        'oid' => $order['order_id'],
        'quantity' => $ingredient['ingredients_needed'],
        'price_per_unit' => $ingredient['ingredient_price'],
        'info' => 'Cost of ' . $ingredient['ingredient_name'] . '.'
    ]);

    // deminish the ingredients needed on ingredient's stock
    $db->query('UPDATE ingredient_tbl SET ingredient_stock = ingredient_stock - :quantity WHERE ingredient_id = :iid', [
        'quantity' => $ingredient['ingredients_needed'],
        'iid' => $ingredient['ingredient_id']
    ]);
}


// record flavor cost on transaction_tbl
$db->query('INSERT INTO transaction_tbl (expense_amount, transaction_type, transaction_datetime, order_id, transaction_info) VALUES (:amount, :type, :datetime, :oid, :info)', [
    'amount' => $order['flavor_cost'],
    'type' => 'EXPENSE',
    'datetime' => date('Y-m-d H:i:s'),
    'oid' => $order['order_id'],
    'info' => 'Cost of Order #' . $order['order_id'] . '\'s flavor.'
]);

//record payment on transaction_tbl
if ($order['order_payment'] != 0) {
    // record downpayment
    $db->query('INSERT INTO transaction_tbl (transaction_type, order_id, income_amount, transaction_datetime, transaction_info) VALUES (:type, :oid, :amount, :datetime, :info)', [
        'type' => 'INCOME',
        'oid' => $order['order_id'],
        'amount' => $order['order_payment'],
        'datetime' => date('Y-m-d H:i:s'),
        'info' => 'Initial Payment of Order #' . $order['order_id'] . '.'
    ]);
}

//update the order status to Ongoing
$db->query('UPDATE order_tbl SET order_status = :status WHERE order_id = :order_id', [
    'status' => 'Ongoing',
    'order_id' => $order['order_id']
]);

//incerement the order_count of customer
$db->query('UPDATE customer_tbl SET customer_order_count = customer_order_count + 1 WHERE customer_id = :cid', [
    'cid' => $order['customer_id']
]);


echo json_encode([
    'success' => true,
    'message' => 'Order status updated successfully'
]);