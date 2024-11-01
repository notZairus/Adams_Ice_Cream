<?php 

$configs = require(base_path('./configs.php'));

$db = new Database($configs['Database']);

//update the order
$db->query('UPDATE order_tbl SET order_payment = order_payment + :amount WHERE order_id = :id', [
  'amount' => $_POST['amount'],
  'id' => $_POST['order_id']
]);

//insert new transaction
$db->query('INSERT INTO transaction_tbl (transaction_type, order_id, income_amount, transaction_datetime, transaction_info) VALUES (:type, :order_id, :amount, :datetime, :info)', [
  'type' => 'INCOME',
  'order_id' => $_POST['order_id'],
  'amount' => $_POST['amount'],
  'datetime' => date('Y-m-d H:i:s'), 
  'info' => 'Payment for the balance of Order #' . $_POST['order_id'] . '.'
]);


//redirect back to orders
header('Location: /orders');
header('Location: /orders');