<?php
require('../../requires.php');


$config = require(base_path('configs.php'));

$db = new Database($config['Database']);

$result = $db->query('SELECT * FROM order_tbl JOIN customer_tbl ON order_tbl.customer_id = customer_tbl.customer_id JOIN flavor_tbl ON order_tbl.flavor_id = flavor_tbl.flavor_id')->fetchAll();

echo json_encode($result);