<?php
require('../requires.php');


$configs = require(base_path('configs.php'));
$db = new Database($configs['Database']);

$data = json_decode(file_get_contents('php://input'), true);

// update order_tbl to Upcomming
$db->query('UPDATE order_tbl SET order_status = "Upcomming" WHERE order_id = :order_id', [
  'order_id' => $data['order_id']
]);


echo json_encode(['success' => true, 'status' => '202']);