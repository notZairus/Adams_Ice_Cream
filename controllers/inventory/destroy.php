<?php

$config = require(base_path('configs.php'));

$db = new Database($config['Database']);

$ingredient = $db->query('SELECT * FROM ingredient_tbl WHERE ingredient_id = :id', [
  'id' => $_POST['ingredient_id']
])->fetch();

$amount = $ingredient['ingredient_stock'] * $ingredient['ingredient_price'];

$db->query('INSERT INTO transaction_tbl (expense_amount, transaction_type, transaction_datetime, ingredient_id, transaction_info) VALUES (:amount, :type, :datetime, :iid, :info)', [
  'amount' => $amount * -1,
  'type' => 'REDUCE EXPENSE',
  'datetime' => date('Y-m-d H:i:s'),
  'iid' => $ingredient['ingredient_id'],
  'info' => 'Deleted ingredient: ' . $ingredient['ingredient_name'] . '.'
]);

$db->query('DELETE FROM ingredient_tbl WHERE ingredient_id = :id', [
  'id' => $_POST['ingredient_id']
]);

header('Location: /inventory');
die();