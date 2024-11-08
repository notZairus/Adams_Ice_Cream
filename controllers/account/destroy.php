<?php

$configs = require(base_path('configs.php'));
$db = new Database($configs['Database']);

$db->query('DELETE FROM user_tbl WHERE user_id = :uid', [
  'uid' => $_POST['user_id']
]);

header('Location: /accounts');