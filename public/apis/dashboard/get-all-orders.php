<?php 

require('../requires.php');

$configs = require(base_path('configs.php'));
$db = new Database($configs['Database']);

$orders = $db->query('SELECT * FROM order_tbl JOIN customer_tbl ON order_tbl.customer_id = customer_tbl.customer_id JOIN flavor_tbl ON order_tbl.flavor_id = flavor_tbl.flavor_id WHERE order_status = "Upcomming"')->fetchAll();

echo json_encode($orders);