<?php 

$config = require(base_path('configs.php'));
$db = new Database($config['Database']);

$username = $_POST['username'];
$password = $_POST['password'];

$db->query("SELECT * FROM user_tbl WHERE username = :username", [
  'username' => $username
]);

$result = $db->fetch();

if (!$result) {
  view('login.view.php', [
      'error' => 'Wrong Credentials.'
  ]);
  die();
}

if (!password_verify($password, $result['password'])) {
  view('login.view.php', [
      'error' => 'Wrong Credentials.'
  ]);
  die();
} else {
  
  session_start();
  $_SESSION['user_id'] = $result['user_id'];
  $_SESSION['username'] = $result['username'];
  $_SESSION['user_role'] = $result['user_role'];
  $_SESSION['user_fullname'] = $result['user_fullname'];

  header("Location: /dashboard");
}
