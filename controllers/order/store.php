<?php 

$config = require(base_path('configs.php'));

$db = new Database($config['Database']);

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

// Redirect to orders page and stop script execution
header('Location: /orders');
die();