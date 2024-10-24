<?php 

$config = require(base_path('configs.php'));

$db = new Database($config['Database']);

$ingredient = $db->query("SELECT * FROM ingredient_tbl WHERE ingredient_id = :id", [
  'id' => $_POST['ingredient_id']
])->fetch();


//INSERT A TRANSACTION BASED ON THE INCREASE OR DECREASE OF INGREDIENT STOCK
if ($_POST['ingredient_stock'] < $ingredient['ingredient_stock']) {

  $difference = $ingredient['ingredient_stock'] - $_POST['ingredient_stock'];
  $amount = $difference * $ingredient['ingredient_price'];

  $db->query('INSERT INTO transaction_tbl (transaction_amount, transaction_type, transaction_info, transaction_datetime) VALUES (:amount, :typee, :info, :datetimee)', [
    'amount' => $amount,
    'typee' => 'REDUCE EXPENSE',
    'info' => 'Decrease the stock of ' . $ingredient['ingredient_name'] . '.',
    'datetimee' => date('Y-m-d H:i:s')
  ]);

} 
else if ($_POST['ingredient_stock'] > $ingredient['ingredient_stock']) {

  $difference = $_POST['ingredient_stock'] - $ingredient['ingredient_stock'];
  $amount = $difference * $ingredient['ingredient_price'];

  $db->query('INSERT INTO transaction_tbl (transaction_amount, transaction_type, transaction_info, transaction_datetime) VALUES (:amount, :typee, :info, :datetimee)', [
    'amount' => $amount,
    'typee' => 'EXPENSE',
    'info' => 'Increase the stock of ' . $ingredient['ingredient_name'] . '.',
    'datetimee' => date('Y-m-d H:i:s')
  ]);

}

//INSERT A TRANSACTION BASED ON THE INCREASE OR DECREASE OF INGREDIENT PRICE
if ($_POST['ingredient_price'] < $ingredient['ingredient_price']) {

  $difference = $ingredient['ingredient_price'] - $_POST['ingredient_price'];
  $amount = $difference * $ingredient['ingredient_stock'];
  
  $db->query('INSERT INTO transaction_tbl (transaction_amount, transaction_type, transaction_info, transaction_datetime) VALUES (:amount, :typee, :info, :datetimee)', [
    'amount' => $amount,
    'typee' => 'REDUCE EXPENSE',
    'info' => 'Decrease in price of ' . $ingredient['ingredient_name'] . '.',
    'datetimee' => date('Y-m-d H:i:s')
  ]);

} 
else if ($_POST['ingredient_price'] > $ingredient['ingredient_price']) {

  $difference = $_POST['ingredient_price'] - $ingredient['ingredient_price'];
  $amount = $difference * $ingredient['ingredient_stock'];

  $db->query('INSERT INTO transaction_tbl (transaction_amount, transaction_type, transaction_info, transaction_datetime) VALUES (:amount, :typee, :info, :datetimee)', [
    'amount' => $amount,
    'typee' => 'EXPENSE',
    'info' => 'Increase in price of ' . $ingredient['ingredient_name'] . '.',
    'datetimee' => date('Y-m-d H:i:s')
  ]);

}

// UPDATE THE SELECTED INGREDIENT
$db->query('UPDATE ingredient_tbl SET ingredient_name = :name, ingredient_price = :price, ingredient_stock = :stock, ingredient_unit = :unit WHERE ingredient_id = :id', [
  'name' => $_POST['ingredient_name'],
  'price' => $_POST['ingredient_price'],
  'stock' => $_POST['ingredient_stock'],
  'unit' => $_POST['ingredient_unit'],
  'id' => $_POST['ingredient_id']
]);

ob_clean();
header('Location: /inventory', true, 302);
header('Location: /inventory', true, 302);
exit();