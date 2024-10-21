<?php

require('../requires.php');
$config = require(base_path('configs.php'));

$db = new Database($config['Database']);
$result = $db->query('SELECT * FROM ingredient_tbl')->fetchAll();

echo json_encode($result);