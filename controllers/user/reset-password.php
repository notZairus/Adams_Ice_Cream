<?php

$configs = require(base_path('configs.php'));
$db = new Database($configs['Database']);

$token = $db->query('SELECT * FROM reset_password_token_tbl WHERE token = :token and expiration_datetime > :noww', [
  'token' => $_GET['token'],
  'noww' => date('Y-m-d H:i:s', strtotime('0 minutes'))
])->fetch();


if($token) {
  return view('reset-password.view.php', [
    'error' => ''
  ]);
} else {
  return view('login.view.php', [
    'error' => 'Expired link.'
  ]);
}