<?php
session_start();

$configs = require(base_path('configs.php'));
$db = new Database($configs['Database']);

$users = $db->query('SELECT * FROM user_tbl')->fetchAll();

view('account/account.view.php', [
  'heading' => 'Accounts',
  'users' => $users
]);