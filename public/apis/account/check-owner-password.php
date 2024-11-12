<?php

require('../requires.php');

$configs = require(base_path('configs.php'));
$db = new Database($configs['Database']);

$data = json_decode(file_get_contents('php://input'), true);

$owner = $db->query('SELECT * FROM user_tbl WHERE user_role = :role', [
  'role' => 'Owner'
])->fetch();


echo json_encode(password_verify($data['password'], $owner['password']));