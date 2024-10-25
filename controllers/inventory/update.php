<?php 

$config = require(base_path('configs.php'));

$db = new Database($config['Database']);

// Fetch the current ingredient data from database
$ingredient = $db->query("SELECT * FROM ingredient_tbl WHERE ingredient_id = :id", [
  'id' => $_POST['ingredient_id']
])->fetch();

// Handle stock quantity changes and create corresponding transaction record and update ingredient stock
if ($_POST['ingredient_stock'] != $ingredient['ingredient_stock']) {

  $difference = abs($ingredient['ingredient_stock'] - $_POST['ingredient_stock']);
  
  $amount = $difference * $ingredient['ingredient_price'];
  $typee = $_POST['ingredient_stock'] < $ingredient['ingredient_stock'] ? 'REDUCE EXPENSE' : 'EXPENSE';
  $info = $_POST['ingredient_stock'] < $ingredient['ingredient_stock'] ? 'Decrease the stock of ' . $ingredient['ingredient_name'] . '.' : 'Increase the stock of ' . $ingredient['ingredient_name'] . '.';

  $db->query('INSERT INTO transaction_tbl (transaction_amount, transaction_type, transaction_info, transaction_datetime) VALUES (:amount, :typee, :info, :datetimee)', [
    'amount' => $amount,
    'typee' => $typee,
    'info' =>  $info,
    'datetimee' => date('Y-m-d H:i:s')
  ]);

  $db->query('UPDATE ingredient_tbl SET ingredient_stock = :stock WHERE ingredient_id = :id', [
    'stock' => $_POST['ingredient_stock'],
    'id' => $_POST['ingredient_id']
  ]);
}

// Refresh ingredient data if both stock and price have changed
if ($_POST['ingredient_stock'] != $ingredient['ingredient_stock'] && $_POST['ingredient_price'] !=  $ingredient['ingredient_price']) {
  $ingredient = $db->query("SELECT * FROM ingredient_tbl WHERE ingredient_id = :id", [
    'id' => $_POST['ingredient_id']
  ])->fetch();
}

// Handle price changes and create corresponding transaction record and update ingredient price
if ($_POST['ingredient_price'] != $ingredient['ingredient_price']) {

  $difference = abs($ingredient['ingredient_price'] - $_POST['ingredient_price']);
  
  $amount = $difference * $ingredient['ingredient_stock'];
  $typee = $_POST['ingredient_price'] < $ingredient['ingredient_price'] ? 'REDUCE EXPENSE' : 'EXPENSE';
  $info = $_POST['ingredient_price'] < $ingredient['ingredient_price'] ? 'Decrease in price of ' . $ingredient['ingredient_name'] . '.' : 'Increase in price of ' . $ingredient['ingredient_name'] . '.';


  $db->query('INSERT INTO transaction_tbl (transaction_amount, transaction_type, transaction_info, transaction_datetime) VALUES (:amount, :typee, :info, :datetimee)', [
    'amount' => $amount,
    'typee' => $typee,
    'info' => $info,
    'datetimee' => date('Y-m-d H:i:s')
  ]);

  $db->query('UPDATE ingredient_tbl SET ingredient_price = :price WHERE ingredient_id = :id', [
    'price' => $_POST['ingredient_price'],
    'id' => $_POST['ingredient_id']
  ]);
}

// Update the remaining ingredient details in the database
$db->query('UPDATE ingredient_tbl SET ingredient_name = :name, ingredient_unit = :unit WHERE ingredient_id = :id', [
  'name' => $_POST['ingredient_name'],
  'unit' => $_POST['ingredient_unit'],
  'id' => $_POST['ingredient_id']
]);

ob_clean();
header('Location: /inventory', true, 302);
header('Location: /inventory', true, 302);
exit();