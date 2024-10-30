<?php 

$config = require(base_path('configs.php'));

$db = new Database($config['Database']);


// Calculate required quantity of ingredients based on order size (in gallons)
$requiredQuantity = $_POST['size'] / 4;

// Fetch all ingredients from the database
$ingredients = $db->query("SELECT * from ingredient_tbl")->fetchAll();

// Array to store ingredients with insufficient stock
$insufficient = [];

// Check if there's enough stock for each ingredient
foreach($ingredients as $ingredient) {
  if ($requiredQuantity * $ingredient['ingredient_usage_per_4_gallons'] > $ingredient['ingredient_stock']) {
    echo "<script> alert('Insufficient ingredient.') </script>";
    header("location: /inventory");
    die();
  }
}

// Update ingredient stock levels by subtracting required quantities
$db->query('UPDATE ingredient_tbl SET ingredient_stock = ingredient_stock - (:size * ingredient_usage_per_4_gallons)', [
  'size' => $requiredQuantity
]);

// Check if customer exists in database by email
$customer = $db->query('SELECT * FROM customer_tbl WHERE customer_email = :email', [
  'email' => $_POST['email']
])->find();

// If customer doesn't exist, create new customer record
if (! $customer) {
  $db->query('INSERT INTO customer_tbl (customer_name, customer_email, customer_contact, customer_order_count) VALUES (:fullname, :email, :contact, :count)', [
    'fullname' => $_POST['name'],
    'email' => $_POST['email'],
    'contact' => $_POST['contact_info'],
    'count' => '0'
  ]);

  // Fetch the newly created customer record
  $customer = $db->query('SELECT * FROM customer_tbl WHERE customer_email = :email', [
    'email' => $_POST['email']
  ])->fetch();
}

// Increment the customer's order count
$db->query('UPDATE customer_tbl SET customer_order_count = customer_order_count + 1 WHERE customer_email = :email', [
  'email' => $_POST['email']
]);

// Insert new order record with customer and order details
$db->query('INSERT INTO order_tbl (order_price, customer_id, order_payment, flavor_id, order_size, order_delivery_address, order_delivery_datetime, order_status, order_placement_datetime) VALUES (:price, :cid, :payment, :flavor, :sizee, :addresss, :datetimee, :statuss, :pdatetime)', [
  'price' => $_POST['size'] == 4 ? 1400 : 2700,
  'cid' => $customer['customer_id'],
  'payment' => $_POST['payment'],
  'flavor' => $_POST['flavor'],
  'sizee' => $_POST['size'],
  'addresss' => $_POST['delivery_adress'],
  'datetimee' => $_POST['delivery_date'] . ' ' . $_POST['delivery_time'],
  'statuss' => 'Upcomming',
  'pdatetime' => date('Y-m-d H:i')
]);


// Fetches the most recent order record from the `order_tbl` table, along with the associated flavor and customer details.
$order = $db->query('SELECT order_tbl.*, flavor_tbl.*, customer_tbl.* FROM order_tbl 
  JOIN flavor_tbl ON order_tbl.flavor_id = flavor_tbl.flavor_id 
  JOIN customer_tbl ON order_tbl.customer_id = customer_tbl.customer_id 
  ORDER BY order_tbl.order_id DESC LIMIT 1')->fetch();


// Record it on transaction_tbl if there is a downpayment
if ($_POST['payment'] != 0) {
  // record downpayment
  $db->query('INSERT INTO transaction_tbl (transaction_type, order_id, income_amount, transaction_datetime) VALUES (:type, :oid, :amount, :datetime)', [
    'type' => 'INCOME',
    'oid' => $order['order_id'],
    'amount' => $_POST['payment'],
    'datetime' => date('Y-m-d H:i:s')
  ]);
}

// Redirect to orders page and stop script execution
header('Location: /orders');
die();