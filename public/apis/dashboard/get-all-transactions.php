<?php 
require('../requires.php');

$configs = require(base_path('configs.php'));
$db = new Database($configs['Database']);

$transactions = $db->query('SELECT * FROM transaction_tbl')->fetchAll();

echo json_encode($transactions);