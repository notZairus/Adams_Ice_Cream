<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;



function dd($data) {
  echo "<pre>";
  var_dump($data);
  echo "</pre>";
  die();
}

function base_path($path) {
  return __DIR__ . '\\' .$path;
}

function view($path, $data = []) {
  extract($data);

  return require(base_path('views\\' . $path));
}

function currentUrl($url) {
  return $_SERVER['REQUEST_URI'] == $url;
}


function sendEmail($data) {

  $keys = require(base_path('api-keys.php'));

  $mail = new PHPMailer(true);

  try {
    // Server settings
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'notZairus@gmail.com'; 
    $mail->Password = $keys['GMAIL_APP_PASSWORD']; 
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port = 587;

    // Recipients
    $mail->setFrom('notZairus@gmail.com', 'Adam\'s Ice Cream'); 
    $mail->addAddress($data['email'], $data['name']); 

    // Content
    $mail->isHTML(true);
    $mail->Subject = $data['subject'];
    $mail->Body    = '<strong>' . $data['body'] . '</strong>';
    $mail->AltBody = $data['body'];

    $mail->send();

  } catch (Exception $e) {
      dd("Error sending email: {$mail->ErrorInfo}");
  }
}