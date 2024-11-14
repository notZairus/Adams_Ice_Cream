<?php
require('../requires.php');
require(base_path('vendor/autoload.php'));


$config = require(base_path('configs.php'));

$db = new Database($config['Database']);


$data = json_decode(file_get_contents('php://input'), true);

$db->query('UPDATE order_tbl SET order_status = :statuss WHERE order_id = :id', [
  'statuss' => 'Finished',
  'id' => $data['order_id']
]);

$customer = $db->query('SELECT * FROM customer_tbl JOIN order_tbl ON customer_tbl.customer_id = order_tbl.customer_id WHERE order_tbl.order_id = :id', [
  'id' => $data['order_id']
])->fetch();

sendEmail([
  'email' => $customer['customer_email'],
  'name' => $customer['customer_name'],
  'subject' => "ADAM'S ICE CREAM: Thanks for being our valued customer! 🍦",
  'body' => "Dear {$customer['customer_name']},<br><br>We're delighted you enjoyed your ice cream experience with us! We hope each scoop brought a smile to your face.<br><br>Come visit us again soon for more delicious treats!<br><br>Best wishes,<br>ADAM'S ICE CREAM"
]);

echo json_encode(['success' => true, 'status' => '202']);