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
$db->query('INSERT INTO transaction_tbl (expense_amount, transaction_type, transaction_datetime, order_id) VALUES (:amount, :type, :datetime, :oid)', [
    'amount' => $order['flavor_cost'],
    'type' => 'EXPENSE',
    'datetime' => date('Y-m-d H:i:s'),
    'oid' => $order['order_id']
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