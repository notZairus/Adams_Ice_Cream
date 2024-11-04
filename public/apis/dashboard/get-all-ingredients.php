<?php
require('../requires.php');

$configs = require(base_path('configs.php'));
$db = new Database($configs['Database']);

$ingredients = $db->query('SELECT * FROM ingredient_tbl')->fetchAll();

echo json_encode($ingredients);