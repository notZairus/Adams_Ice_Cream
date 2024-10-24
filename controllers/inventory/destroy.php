<?php

$config = require(base_path('configs.php'));

$db = new Database($config['Database']);

$ingredient = $db->query('SELECT * FROM ingredient_tbl WHERE ingredient_id = :id', [
  'id' => $_POST['ingredient_id']
])->fetch();

$amount = $ingredient['ingredient_stock'] * $ingredient['ingredient_price'];

$db->query('INSERT INTO transaction_tbl (transaction_amount, transaction_type, transaction_info, transaction_datetime) VALUES (:amount, :type, :info, :datetime)', [
  'amount' => $amount,
  'type' => 'REDUCE EXPENSE', 
  'info' => "Deleted the entire " . $ingredient['ingredient_name'] . '\'s stock.',
  'datetime' => date('Y-m-d H:i:s')
]);

$db->query('DELETE FROM ingredient_tbl WHERE ingredient_id = :id', [
  'id' => $_POST['ingredient_id']
]);

header('Location: /inventory');
die();