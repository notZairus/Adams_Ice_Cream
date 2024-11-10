<?php

$configs = require(base_path('configs.php'));
$db = new Database($configs['Database']);

$db->query('INSERT INTO user_tbl (username, user_fullname, user_email, password) VALUES (:username, :name, :email, :password)', [
    'username' => $_POST['username'],
    'name' => $_POST['fullname'],
    'email' => $_POST['email'],
    'password' => password_hash($_POST['password'], PASSWORD_DEFAULT)
]);

header('location: /accounts');