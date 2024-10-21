<?php 

$config = require(base_path('configs.php'));

$db = new Database($config['Database']);

$customer = $db->query('SELECT * FROM customer_tbl WHERE customer_email = :email', [
  'email' => $_POST['email']
])->find();


if (! $customer) {
  $db->query('INSERT INTO customer_tbl (customer_name, customer_email, customer_contact, customer_order_count) VALUES (:fullname, :email, :contact, :count)', [
    'fullname' => $_POST['name'],
    'email' => $_POST['email'],
    'contact' => $_POST['contact_info'],
    'count' => '0'
  ]);

  $customer = $db->query('SELECT * FROM customer_tbl WHERE customer_email = :email', [
    'email' => $_POST['email']
  ])->find();
}


$db->query('INSERT INTO order_tbl (
  customer_id, 
  order_flavor, 
  order_size, 
  order_delivery_address, 
  order_delivery_datetime, 
  order_status, 
  order_placement_datetime
) VALUES (  
  :cid,
  :flavor,
  :sizee,
  :addresss,
  :datetimee,
  :statuss,
  :pdatetime
)', [
  'cid' => $customer['customer_id'],
  'flavor' => $_POST['flavor'],
  'sizee' => $_POST['size'],
  'addresss' => $_POST['delivery_adress'],
  'datetimee' => $_POST['delivery_date'] . ' ' . $_POST['delivery_time'],
  'statuss' => 'Upcomming',
  'pdatetime' => date('Y-m-d H:i')
]); 


$db->query('UPDATE customer_tbl SET customer_order_count = customer_order_count + 1 WHERE customer_email = :email', [
  'email' => $_POST['email']
]);


header('Location: /orders');