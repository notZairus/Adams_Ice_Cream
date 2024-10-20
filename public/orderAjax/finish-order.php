<?php

require('../requires.php');

$config = require(base_path('configs.php'));

$db = new Database($config['Database']);


$data = json_decode(file_get_contents('php://input'), true);

$db->query('UPDATE order_tbl SET order_status = :statuss WHERE order_id = :id', [
  'statuss' => 'Finished',
  'id' => $data['order_id']
]);