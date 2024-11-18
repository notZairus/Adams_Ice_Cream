

<dialog id="add_user_modal" class="add_user_modal modal">
  <h2>Add User</h2>
  <form class="add-user-form" id="add_user_form" action="/accounts" method="POST">
    <div class="input-field">
      <label for="name">Email: </label>
      <br>
      <input type="email" id="email" name="email" min="7" required>
    </div>

    <div class="input-field">
      <label for="fullname">Full Name: </label>
      <br>
      <input type="text" id="fullname" name="fullname" required>
    </div>

    <div class="input-field">
      <label for="username">Username: </label>
      <br>
      <input type="text" id="username" name="username" minlength="4" required>
    </div>

    <br>

    <div class="input-field">
      <label for="password">Password: </label>
      <br>
      <input type="password" id="password" name="password" minlength="8" required>
    </div>

    

    <div class="btn-container">
      <button type="button" id="close_add_user_modal">Cancel</button>
      <button type="submit">Add User</button>
    </div>

  </form>

</dialog>