<?php

require('../requires.php');

$config = require(base_path('configs.php'));
$db = new Database($config['Database']);


$data = json_decode(file_get_contents('php://input'), true);

// get the order details
$order = $db->query('SELECT * FROM order_tbl JOIN flavor_tbl ON order_tbl.flavor_id = flavor_tbl.flavor_id WHERE order_tbl.order_id = :order_id', [
    'order_id' => $data['order_id']
])->fetch();

// record flavor cost on transaction_tbl
$db->query('INSERT INTO transaction_tbl (transaction_info, transaction_amount, transaction_type, transaction_datetime) VALUES (:info, :amount, :type, :datetime)', [
    'info' => 'Flavor Cost',
    'amount' => $order['flavor_cost'],
    'type' => 'EXPENSE',
    'datetime' => date('Y-m-d H:i:s')
]);

//update the order status to Ongoing
$db->query('UPDATE order_tbl SET order_status = :status WHERE order_id = :order_id', [
    'status' => 'Ongoing',
    'order_id' => $order['order_id']
]);

echo json_encode([
    'success' => true,
    'message' => 'Order status updated successfully'
]);