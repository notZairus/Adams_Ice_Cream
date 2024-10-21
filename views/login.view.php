<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Adam's Ice Cream</title>
  <link rel="stylesheet" href="/css/general.css">
  <link rel="stylesheet" href="/css/login.css">
  <style>
  </style>
</head>
  <body>
    <div class="wrapper">
      <form action="/login" method="POST">
        <input type="hidden" name="__method" value="POST">
        <h1>Adam's Ice Cream</h1>

        <div class="field">
          <label for="username">Username:</label><br>
          <input type="text" id="username" name="username" required>
        </div>

        <div class="field">
          <label for="password">Password:</label><br>
          <input type="password" id="password" name="password" required>
        </div>

        <p class="error-msg"><?= $error ?></p>

        <div class="button-container">
          <button>Sign in</button>
        </div>
      </form>
    </div>
  </body>
</html>