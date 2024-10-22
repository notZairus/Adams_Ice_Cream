<?php 

$config = require(base_path('configs.php'));

$db = new Database($config['Database']);

$flavors = $db->query('SELECT * FROM flavor_tbl')->fetchAll();


view('order/flavors.view.php', [
  'heading' => 'Flavors',
  'flavors' => $flavors
]);