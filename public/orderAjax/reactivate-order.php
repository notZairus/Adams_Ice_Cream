<?php

require('../requires.php');

$configs = require(base_path('configs.php'));
$db = new Database($configs['Database']);

$data = json_decode(file_get_contents('php://input'), true);


// get order info
$order = $db->query('SELECT * FROM order_tbl WHERE order_id = :order_id', [
  'order_id' => $data['order_id']
])->fetch();


// substract the reserved ingredient base on its size back into the ingredient_tbl
$size = $order['order_size'] / 4;
$db->query('UPDATE ingredient_tbl SET ingredient_stock = ingredient_stock - (ingredient_usage_per_4_gallons * :size)', [
    'size' => $size
]);


// update order_tbl to Upcomming
$db->query('UPDATE order_tbl SET order_status = "Upcomming" WHERE order_id = :order_id', [
  'order_id' => $order['order_id']
]);


// check if there is a downpayment
// if there is a downpayment, make a new record about the reactivation of the order on the transaction_tbl
if ($order['order_payment'] > 0) {
  $db->query('INSERT INTO transaction_tbl (transaction_info, transaction_amount, transaction_type, transaction_datetime) VALUES (:info, :amount, :type, :datetime)', [
    'info' => 'Reactivation of order_id: ' . $order['order_id'] . '.',
    'amount' => $order['order_payment'],
    'type' => 'INCOME',
    'datetime' => date('Y-m-d H:i:s')
  ]);
}


echo json_encode(['success' => true, 'status' => '202']);