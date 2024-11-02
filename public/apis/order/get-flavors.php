<?php
require('../../requires.php');


$configs = require(base_path('configs.php'));

$db = new Database($configs['Database']);

$flavors = $db->query('SELECT * FROM flavor_tbl')->fetchAll();

echo json_encode($flavors);