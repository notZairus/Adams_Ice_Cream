<?php
require('../requires.php');
require(base_path('vendor/autoload.php'));


$config = require(base_path('configs.php'));
$db = new Database($config['Database']);

$data = json_decode(file_get_contents('php://input'), true);


// get the order details
$order = $db->query('SELECT * FROM order_tbl JOIN flavor_tbl ON order_tbl.flavor_id = flavor_tbl.flavor_id WHERE order_tbl.order_id = :order_id', [
    'order_id' => $data['order_id']
])->fetch();


$ingredients_needed = $db->query('SELECT ingredient_tbl.ingredient_id, ingredient_tbl.ingredient_name, ingredient_tbl.ingredient_price, order_tbl.order_size / 4 * ingredient_tbl.ingredient_usage_per_4_gallons AS "ingredients_needed" FROM order_tbl, ingredient_tbl WHERE order_tbl.order_id = :id', [
    'id' => $order['order_id']
])->fetchAll();

foreach ($ingredients_needed as $ingredient) {
    
    // record each ingredient cost on transaction_tbl
    $db->query('INSERT INTO transaction_tbl (expense_amount, transaction_type, transaction_datetime, ingredient_id, order_id, ingredient_quantity, ingredient_price_per_unit, transaction_info) VALUES (:amount, :type, :datetime, :iid, :oid, :quantity, :price_per_unit, :info)', [
        'amount' => $ingredient['ingredients_needed'] * $ingredient['ingredient_price'],
        'type' => 'EXPENSE',
        'datetime' => date('Y-m-d H:i:s'),
        'iid' => $ingredient['ingredient_id'],
        'oid' => $order['order_id'],
        'quantity' => $ingredient['ingredients_needed'],
        'price_per_unit' => $ingredient['ingredient_price'],
        'info' => 'Cost of ' . $ingredient['ingredient_name'] . '.'
    ]);

    // deminish the ingredients needed on ingredient's stock
    $db->query('UPDATE ingredient_tbl SET ingredient_stock = ingredient_stock - :quantity WHERE ingredient_id = :iid', [
        'quantity' => $ingredient['ingredients_needed'],
        'iid' => $ingredient['ingredient_id']
    ]);
}


// record flavor cost on transaction_tbl
$db->query('INSERT INTO transaction_tbl (expense_amount, transaction_type, transaction_datetime, order_id, transaction_info) VALUES (:amount, :type, :datetime, :oid, :info)', [
    'amount' => $order['flavor_cost'],
    'type' => 'EXPENSE',
    'datetime' => date('Y-m-d H:i:s'),
    'oid' => $order['order_id'],
    'info' => 'Cost of Order #' . $order['order_id'] . '\'s flavor.'
]);

//record payment on transaction_tbl
if ($order['order_payment'] != 0) {
    // record downpayment
    $db->query('INSERT INTO transaction_tbl (transaction_type, order_id, income_amount, transaction_datetime, transaction_info) VALUES (:type, :oid, :amount, :datetime, :info)', [
        'type' => 'INCOME',
        'oid' => $order['order_id'],
        'amount' => $order['order_payment'],
        'datetime' => date('Y-m-d H:i:s'),
        'info' => 'Initial Payment of Order #' . $order['order_id'] . '.'
    ]);
}

//update the order status to Ongoing
$db->query('UPDATE order_tbl SET order_status = :status WHERE order_id = :order_id', [
    'status' => 'Ongoing',
    'order_id' => $order['order_id']
]);

//incerement the order_count of customer
$db->query('UPDATE customer_tbl SET customer_order_count = customer_order_count + 1 WHERE customer_id = :cid', [
    'cid' => $order['customer_id']
]);

//increment the order_count of the flavor
$db->query('UPDATE flavor_tbl SET flavor_order_count = flavor_order_count + 1 WHERE flavor_id = :fid', [
    'fid' => $order['flavor_id']
]);

$customer = $db->query('SELECT * FROM customer_tbl WHERE customer_id = :cid', [
    'cid' => $order['customer_id']
])->fetch();

sendEmail([
    'email' => $customer['customer_email'],
    'name' => $customer['customer_name'],
    'subject' => "ADAM'S ICE CREAM: Thanks for being our valued customer! 🍦",
    'body' => "<html>
                <head>
                  <style>
                      body {
                          font-family: Arial, sans-serif;
                          margin: 0;
                          padding: 0;
                          background-color: #f9f9f9;
                      }
                      .container {
                          width: 90%;
                          max-width: 600px;
                          margin: 20px auto;
                          background: #ffffff;
                          border-radius: 8px;
                          box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
                          overflow: hidden;
                      }
                      .header {
                          background: #334259;
                          color: #ffffff;
                          text-align: center;
                          padding: 20px;
                      }
                      .header h1 {
                          margin: 0;
                          font-size: 24px;
                      }
                      .content {
                          padding: 20px;
                          color: #333333;
                      }
                      .content p {
                          margin: 8px 0;
                      }
                      .content .order-table {
                          width: 100%;
                          border-collapse: collapse;
                          margin: 20px 0;
                      }
                      .order-table th, .order-table td {
                          border: 1px solid #dddddd;
                          text-align: left;
                          padding: 8px;
                      }
                      .order-table th {
                          background: #334259;
                          color: #ffffff;
                      }
                      .footer {
                          text-align: center;
                          background: #334259;
                          color: #ffffff;
                          padding: 10px;
                          font-size: 14px;
                      }
                      .footer a {
                          color: #ffffff;
                          text-decoration: underline;
                      }
                  </style>
              </head>
              <body>
                  <div class='container'>
                      <div class='header'>
                          <h1>ADAM'S ICE CREAM</h1>
                          <p>Thanks for being our valued customer! 🍦</p>
                      </div>
                      <div class='content'>
                          Dear {$customer['customer_name']},<br><br>Your delicious ice cream order is now ready and will be on its way to you shortly! We've crafted your order with premium ingredients and lots of care.<br><br>Get ready to enjoy your ice cream treats!<br><br>Best regards,<br>ADAM'S ICE CREAM
                      </div>
                  </div>
              </body>
              </html>"
  ]);


echo json_encode([
    'success' => true,
    'message' => 'Order status updated successfully'
]);