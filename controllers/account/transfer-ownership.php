<?php

$configs = require(base_path('configs.php'));
$db = new Database($configs['Database']);


$db->query('UPDATE user_tbl SET user_role = :role WHERE user_role = :usrrole', [
  'role' => "Employee",
  'usrrole' => 'Owner'
]);

$db->query('UPDATE user_tbl SET user_role = :role WHERE user_id = :uid', [
  'role' => "Owner",
  'uid' => $_POST['user_id']
]);

session_destroy();

header('location: /login');