<?php


require('../requires.php');

$configs = require(base_path('configs.php'));
$db = new Database($configs['Database']);

$data = json_decode(file_get_contents('php://input'), true);


// get order info
$order = $db->query('SELECT * FROM order_tbl WHERE order_id = :order_id', [
  'order_id' => $data['order_id']
])->fetch();

// add the reserved ingredient base on its size back into the ingredient_tbl
$size = $order['order_size'] / 4;
$db->query('UPDATE ingredient_tbl SET ingredient_stock = ingredient_stock + (ingredient_usage_per_4_gallons * :size)', [
    'size' => $size
]);


// update order_tbl to cancelled
$db->query('UPDATE order_tbl SET order_status = "Cancelled" WHERE order_id = :order_id', [
    'order_id' => $data['order_id']
]);


// check if there is a downpayment
// if there is a downpayment, make a new record about the refund on the transaction_tbl
if ($order['order_payment'] > 0) {
  $db->query('INSERT INTO transaction_tbl (income_amount, transaction_type, transaction_datetime, order_id) VALUES (:amount, :type, :datetime, :oid)', [
    'amount' => $order['order_payment'] * -1,
    'type' => 'REDUCE INCOME',
    'datetime' => date('Y-m-d H:i:s'),
    'oid' => $order['order_id']
  ]);
}


echo json_encode(['success' => true, 'status' => '202']);