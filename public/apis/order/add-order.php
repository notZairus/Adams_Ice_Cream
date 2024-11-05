<?php
require('../requires.php');


$configs = require(base_path('configs.php'));
$db = new Database($configs['Database']);
 
$data = json_decode(file_get_contents('php://input'), true);
$newCustomer = $data['customer'];
$orders = $data['orders'];

// Check if customer exists in database by email
$customer = $db->query('SELECT * FROM customer_tbl WHERE customer_email = :email', [
  'email' => $newCustomer['email']
])->find();

// If customer doesn't exist, create new customer record
if (! $customer) {
  $db->query('INSERT INTO customer_tbl (customer_name, customer_email, customer_contact, customer_order_count) VALUES (:fullname, :email, :contact, :count)', [
    'fullname' => $newCustomer['name'],
    'email' => $newCustomer['email'],
    'contact' => $newCustomer['contact'],
    'count' => '0'
  ]);

  // Fetch the newly created customer record
  $customer = $db->query('SELECT * FROM customer_tbl WHERE customer_email = :email', [
    'email' => $newCustomer['email']
  ])->fetch();
}

foreach($orders as $order) {

  // Insert new order record with customer and order details
  $db->query('INSERT INTO order_tbl (order_price, customer_id, order_payment, flavor_id, order_size, order_delivery_address, order_delivery_datetime, order_status, order_placement_datetime) VALUES (:price, :cid, :payment, :flavor, :sizee, :addresss, :datetimee, :statuss, :pdatetime)', [
    'price' => $order['size'] == 4 ? 1400 : 2700,
    'cid' => $customer['customer_id'],
    'payment' => $order['initial_payment'],
    'flavor' => $order['flavor'],
    'sizee' => $order['size'],
    'addresss' => $order['delivery_address'],
    'datetimee' => $order['delivery_date'] . ' ' . $order['delivery_time'],
    'statuss' => 'Upcomming',
    'pdatetime' => date('Y-m-d H:i')
  ]);

}

echo json_encode([
  'message' => 'success',
  'status' => 200
]);