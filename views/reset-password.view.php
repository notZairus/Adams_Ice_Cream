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
      <form action="/reset-password" method="POST">
        <input type="hidden" name="_method" value="PATCH">
        <h1>Reset Password</h1>

        <div class="field">
          <label for="password">New Password:</label><br>
          <input type="password" id="password" name="password" minlength="8" required>
        </div>

        <div class="field">
          <label for="confirm_password">Confirm Password:</label><br>
          <input type="password" id="confirm_password" name="confirm_password" minlength="8" required>
        </div>
        
        <p class="error-msg"><?= $error ?></p>

        <div class="button-container">
          <button>Confirm</button>
        </div>

      </form>
    </div>
  </body>
</html>