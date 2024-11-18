<?php 

require('../requires.php');

$configs = require(base_path('configs.php'));
$db = new Database($configs['Database']);

$ingredient = json_decode(file_get_contents('php://input'), true);

$db->query('INSERT INTO ingredient_tbl (ingredient_name, ingredient_price, ingredient_reminder, ingredient_unit, ingredient_usage_per_4_gallons) VALUES (:name, :price, :reminder, :unit, :usage_per_4_gallons)', [
  'name' => $ingredient['ingredient_name'],
  'price' => $ingredient['ingredient_price'],
  'reminder' => $ingredient['ingredient_reminder'],
  'unit' => $ingredient['ingredient_unit'],
  'usage_per_4_gallons' => $ingredient['ingredient_usage_per_4_gallons'],
]);

echo json_encode(['status' => 200, 'success' => true]);