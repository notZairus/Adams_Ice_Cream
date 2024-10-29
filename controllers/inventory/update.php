<?php 

$config = require(base_path('configs.php'));
$db = new Database($config['Database']);


// get ingredient details from database
$ingredient = $db->query('SELECT * FROM ingredient_tbl WHERE ingredient_id = :id', [
  'id' => $_POST['ingredient_id']
])->find();


if ($_POST['ingredient_stock'] != $ingredient['ingredient_stock']) {
    
    // get the data needed to insert on transaction_tbl
    $type = $_POST['ingredient_stock'] > $ingredient['ingredient_stock'] ? 'EXPENSE' : 'REDUCE EXPENSE';
    $additionalStock = $_POST['ingredient_stock'] - $ingredient['ingredient_stock'];
    $pricePerUnit = $_POST['ingredient_stock'] > $ingredient['ingredient_stock'] ? $_POST['ingredient_price'] : $ingredient['ingredient_price'];

    $totalCost = $_POST['ingredient_stock'] > $ingredient['ingredient_stock'] ? abs($additionalStock * $_POST['ingredient_price']) : abs($additionalStock * $ingredient['ingredient_price']);
    $amount = $_POST['ingredient_stock'] > $ingredient['ingredient_stock'] ? $totalCost : $totalCost * -1;

    // insertion time!!!
    $db->query('INSERT INTO transaction_tbl (transaction_type, ingredient_id, ingredient_quantity, ingredient_price_per_unit, expense_amount, transaction_datetime) VALUES (:type, :ingredient_id, :quantity, :price_per_unit, :expense_amount, :transaction_datetime)', [
        'type' => $type,
        'ingredient_id' => $_POST['ingredient_id'],
        'quantity' => $additionalStock,
        'price_per_unit' => $pricePerUnit,
        'expense_amount' => $amount,
        'transaction_datetime' => date('Y-m-d H:i:s')
    ]);
    
    // update ingredient stock
    $db->query('UPDATE ingredient_tbl SET ingredient_stock = :stock WHERE ingredient_id = :id', [
      'stock' => $_POST['ingredient_stock'],
      'id' => $_POST['ingredient_id']
    ]);

}

//update the ingredient details on ingredient_tbl
$db->query('UPDATE ingredient_tbl SET ingredient_name = :name, ingredient_price = :price, ingredient_unit = :unit, ingredient_usage_per_4_gallons = :usage WHERE ingredient_id = :id', [
  'name' => $_POST['ingredient_name'],
  'price' => $_POST['ingredient_price'],
  'unit' => $_POST['ingredient_unit'],
  'usage' => $_POST['ingredient_usage_per_4_gallons'],
  'id' => $_POST['ingredient_id']
]);


header('Location: /inventory');
header('Location: /inventory');