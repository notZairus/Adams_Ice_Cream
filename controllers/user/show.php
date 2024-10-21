<?php 
session_start();


$config = require(base_path('configs.php'));
$db =  new Database($config['Database']);


$username = $_POST['username'];
$password = $_POST['password'];



$db->query("SELECT * FROM user_tbl WHERE username = :username", [
  'username' => $username
]);

$result = $db->fetch();

if (! $result) {
  view('login.view.php', [
    'error' => 'Wrong Credentials.'
  ]);
  die();
}

if ($result['password'] != $_POST['password']) {
  view('login.view.php', [
    'error' => 'Wrong Credentials.'
  ]);
  die();
} else {
  
  $_SESSION['user_id'] = $result['user_id'];
  $_SESSION['username'] = $result['username'];
  $_SESSION['password'] = $result['password'];

  header("Location: /dashboard");
}

