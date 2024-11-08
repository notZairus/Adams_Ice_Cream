



<?php require(base_path('views/partials/app-head-top.php')) ?>

<!-- STYLESHEETS -->
<link rel="stylesheet" href="/css/general.css">
<link rel="stylesheet" href="/css/app.css">
<link rel="stylesheet" href="/css/flavor.css">
<link rel="stylesheet" href="/css/account.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">


<!-- SCRIPTS -->
<script defer src="/js/functions.js"></script>

<?php require(base_path('views/partials/app-head-bottom.php')) ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
  
<main>

  <form class="grid-item" action="/accounts" method="POST">
 required
    <div class="form-group">
      <label for="exampleInputEmail1">Email address</label>
      <input type="email" class="form-control" placeholder="Enter email" name="email" required>
      <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
    </div>

    <div class="form-group">
      <label for="exampleInputEmail1">Full Name</label>
      <input type="email" class="form-control" name="fullname" placeholder="Enter fullname" required>
    </div>

    <div class="form-group">
      <label for="exampleInputEmail1">Username</label>
      <input type="email" class="form-control" name="username" placeholder="Enter username" required>
    </div>

    <div class="form-group">
      <label for="exampleInputPassword1">Password</label>
      <input type="password" class="form-control" name="password" placeholder="Password" required>
    </div>

    <button type="submit" class="btn btn-primary" style="background-color: var(--primary-color);">Submit</button>
  </form>


</main>



<?php require(base_path('views/partials/app-foot.php')) ?>