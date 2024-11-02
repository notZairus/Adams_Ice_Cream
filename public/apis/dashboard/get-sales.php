<?php 
require('../../requires.php');

$configs = require(base_path('configs.php'));

$db = new Database($configs['Database']);

$sales;

$sales['expenses'] = $db->query('SELECT * FROM transaction_tbl WHERE transaction_type IN (:type1, :type2)', [
  'type1' => 'EXPENSE',
  'type2' => 'REDUCE EXPENSE'
])->fetchAll();

$sales['incomes'] = $db->query('SELECT * FROM transaction_tbl WHERE transaction_type IN (:type1, :type2)', [
  'type1' => 'INCOME',
  'type2' => 'REDUCE INCOME'
])->fetchAll();

echo json_encode($sales);