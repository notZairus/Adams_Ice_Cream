<?php
require('../requires.php');
require(base_path('vendor/autoload.php'));


$keys = require(base_path('api-keys.php'));
$configs = require(base_path('configs.php'));
$db = new Database($configs['Database']);

$owner = $db->query('SELECT * FROM user_tbl WHERE user_role = :role', [
  'role' => 'Owner'
])->fetch();


$token = bin2hex(random_bytes(32));
$expiration = date('Y-m-d H:i:s', strtotime('+10 minutes'));

$db->query('INSERT INTO reset_password_token_tbl (email, token, expiration_datetime) VALUES (:email, :token, :expi)', [
    'email' => $owner['user_email'],
    'token' => $token,
    'expi' => $expiration
]);

$link = 'localhost:8080/reset-password?token=' . $token;

sendEmail([
  'email' => $owner['user_email'],
  'name' => $owner['user_fullname'],
  'subject' => 'Password Reset',
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
                      .btn-reset {
                          display: inline-block;
                          background: #f05454;
                          color: #ffffff;
                          text-decoration: none;
                          padding: 10px 20px;
                          border-radius: 4px;
                          font-weight: bold;
                          margin-top: 20px;
                      }
                      .btn-reset:hover {
                          background: #d04343;
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
                          <p>Password Reset Request 🍦</p>
                      </div>
                      <div class='content'>
                          <p>Hi {$owner['user_fullname']},</p>
                          <p>We received a request to reset your password for your ADAM'S ICE CREAM account. If you didn't request a password reset, please ignore this email.</p>
                          <p>To reset your password, click the button below:</p>
                          <a href='$link' class='btn-reset'>Reset My Password</a>
                          <p>If the button doesn't work, you can copy and paste the link below into your browser:</p>
                          <p><a href='$link'>$link</a></p>
                          <p>Best regards,<br>ADAM'S ICE CREAM</p>
                      </div>
                      <div class='footer'>
                          <p>&copy; " . date('Y') . " ADAM'S ICE CREAM. All rights reserved.</p>
                      </div>
                  </div>
              </body>
              </html>"
]);


echo json_encode([
  'status' => 'success',
  'message' => 'Password reset link sent to your email'
]);