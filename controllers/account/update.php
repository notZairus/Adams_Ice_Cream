

<?php

$configs = require(base_path('configs.php'));
$db = new Database($configs['Database']);

$db->query('UPDATE user_tbl SET user_email = :email, user_fullname = :fullname, username = :un, password = :pwd WHERE user_id = :uid', [
  'email' => $_POST['email'],
  'fullname' => $_POST['fullname'],
  'un' => $_POST['username'],
  'pwd' => password_hash($_POST['password'], PASSWORD_DEFAULT),
  'uid' => $_POST['user_id']
]);

header('location: /accounts');