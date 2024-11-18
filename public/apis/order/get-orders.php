<?php
require('../requires.php');


$config = require(base_path('configs.php'));

$db = new Database($config['Database']);

$result = $db->query('SELECT * FROM order_tbl JOIN customer_tbl ON order_tbl.customer_id = customer_tbl.customer_id JOIN flavor_tbl ON order_tbl.flavor_id = flavor_tbl.flavor_id ORDER BY order_tbl.order_delivery_datetime ASC')->fetchAll();

echo json_encode($result);