<?php

$config = require(base_path('configs.php'));

$db = new Database($config['Database']);

if ($_POST['action'] == 'add_ingredient') {

  $db->query('INSERT INTO ingredient_tbl (ingredient_name, ingredient_price,ingredient_unit,ingredient_reminder, ingredient_usage_per_4_gallons) VALUES (:ingredient_name, :ingredient_price,:ingredient_unit,:ingredient_reminder, :ingredient_usage_per_4_gallons)', [
    'ingredient_name' => $_POST['ingredient_name'],
    'ingredient_price' => $_POST['ingredient_price'],
    'ingredient_unit' => $_POST['ingredient_unit'],
    'ingredient_reminder' => $_POST['ingredient_reminder'],
    'ingredient_usage_per_4_gallons' => $_POST['ingredient_usage_per_4_gallons'],
  ]);
  
} 
else if ($_POST['action'] == 'add_stock') {

  // Update ingredient stock quantity
  $db->query('UPDATE ingredient_tbl SET ingredient_stock = ingredient_stock + :stock WHERE ingredient_id = :id', [
    'stock' => $_POST['new_stocks'],
    'id' => $_POST['ingredient_id']
  ]);
  
}

header('Location: /inventory');
die();