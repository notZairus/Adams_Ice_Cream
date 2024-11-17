<?php
require('../requires.php');
require(base_path('vendor/autoload.php'));


$config = require(base_path('configs.php'));

$db = new Database($config['Database']);


$data = json_decode(file_get_contents('php://input'), true);

$db->query('UPDATE order_tbl SET order_status = :statuss WHERE order_id = :id', [
  'statuss' => 'Finished',
  'id' => $data['order_id']
]);

$customer = $db->query('SELECT * FROM customer_tbl JOIN order_tbl ON customer_tbl.customer_id = order_tbl.customer_id JOIN flavor_tbl ON order_tbl.flavor_id = flavor_tbl.flavor_id WHERE order_tbl.order_id = :id', [
  'id' => $data['order_id']
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
                        <p>Hi {$customer['customer_name']},</p>
                        <p>Thank you for your recent purchase! Here’s your receipt:</p>
                        <table class='order-table'>
                            <thead>
                                <tr>
                                    <th>Item</th>
                                    <th>Size</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>{$customer['flavor_name']} Ice Cream</td>
                                    <td>{$customer['order_size']} gallons</td>
                                </tr>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th style='text-align: right;'>Grand Total:</th>
                                    <th> {$customer['order_price']} </th>
                                </tr>
                            </tfoot>
                        </table>
                        <p>If you have any questions or need support, don’t hesitate to reach out to us!</p>
                        <p>We hope to see you again soon!</p>
                    </div>
                </div>
            </body>
            </html>"
]);

echo json_encode(['success' => true, 'status' => '202']);