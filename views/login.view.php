<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Adam's Ice Cream</title>
    <link rel="stylesheet" href="/css/general.css">
    <link rel="stylesheet" href="/css/app.css">
    <link rel="stylesheet" href="/css/login.css">
    <script defer src="/js/functions.js"></script>
    <script defer src="/js/login.js"></script>
  </head>
  <body>
    
    <!-- MODALS -->
    <?php require(base_path('views/app/modals/confirmation-modal.php')) ?>
    <?php require(base_path('views/app/modals/message-modal.php')) ?>

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

        <p class="forgot-password-a">Forgot Password?</p> 

      </form>
    </div>
  </body>
</html>