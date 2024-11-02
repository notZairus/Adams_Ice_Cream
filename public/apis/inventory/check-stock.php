<?php
require('../../requires.php');

$configs = require(base_path('configs.php'));
$db = new Database($configs['Database']);

$data = json_decode(file_get_contents('php://input'), true);
$ingredients = $db->query('SELECT * FROM ingredient_tbl')->fetchAll();
$requiredQuantity = $data['size'] / 4;

foreach ($ingredients as $ingredient) {
  if ($requiredQuantity * $ingredient['ingredient_usage_per_4_gallons'] > $ingredient['ingredient_stock']) {
    echo json_encode(false);
    die();
  }
}

echo json_encode(true);