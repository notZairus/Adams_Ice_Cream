<?php 

require('../requires.php');

$configs = require(base_path('configs.php'));

$db = new Database($configs['Database']);

$cost = $db->query('SELECT SUM(CASE WHEN transaction_type = "EXPENSE" THEN transaction_amount ELSE 0 END) - SUM(CASE WHEN transaction_type = "REDUCE EXPENSE" THEN transaction_amount ELSE 0 END) AS "cost" FROM transaction_tbl')->fetch();

echo json_encode($cost['cost']);


//IM IMPLEMENTING THISSSS!!
//IM IMPLEMENTING THISSSS!!
//IM IMPLEMENTING THISSSS!!
//IM IMPLEMENTING THISSSS!!
//IM IMPLEMENTING THISSSS!!
//IM IMPLEMENTING THISSSS!!

