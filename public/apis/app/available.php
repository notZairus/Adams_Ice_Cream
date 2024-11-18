<?php

require('../requires.php');

$configs = require(base_path('configs.php'));
$db = new Database($configs['Database']);

$data = json_decode(file_get_contents('php://input'), true);

$table = $data['table'];
$column = $data['column'];
$value = $data['value'];

$exists = $db->query('SELECT * FROM ' . $table . ' WHERE ' . $column . ' = :value', [
  'value' => $value
])->fetch();

if (! $exists) {
  echo json_encode(true);
} else {
  echo json_encode(false);
}

exit();