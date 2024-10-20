<?php 

require('../requires.php');

$configs = require(base_path('configs.php'));

$db = new Database($configs['Database']);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $data = json_decode(file_get_contents('php://input'), true);

  $orders = $db->query('SELECT * FROM order_tbl JOIN customer_tbl ON order_tbl.customer_id = customer_tbl.customer_id WHERE order_status = :statuss', [
    'statuss' => $data['category']
  ])->fetchAll();

  echo json_encode($orders);
}