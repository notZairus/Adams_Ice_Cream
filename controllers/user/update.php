<?php

$configs = require(base_path('configs.php'));
$db = new Database($configs['Database']);

if ($_POST['password'] != $_POST['confirm_password']) {
  return view('reset-password.view.php', [
    'error' => "The new password and confirmation password do not match."
  ]);
}

$db->query('UPDATE user_tbl SET password = :pwd WHERE user_role = :urole', [
  'pwd' => password_hash($_POST['password'], PASSWORD_DEFAULT),
  'urole' => 'Owner'
]);

header('location: /login');
exit();