



<dialog id="edit_user_modal" class="edit_user_modal modal">
  <h2>Edit User</h2>
  <form class="add-user-form" action="/accounts" method="POST">
    <div class="input-field">
      <label for="name">Email: </label>
      <br>
      <input type="email" id="edemail" name="email" min="7" required>
    </div>

    <div class="input-field">
      <label for="fullname">Full Name: </label>
      <br>
      <input type="text" id="edfullname" name="fullname" required>
    </div>

    <div class="input-field">
      <label for="username">Username: </label>
      <br>
      <input type="text" id="edusername" name="username" required>
    </div>

    <br>

    <div class="input-field">
      <label for="password">Password: </label>
      <br>
      <input type="password" id="edpassword" name="password" required>
    </div>

    <input type="hidden" name="_method" value="PATCH">
    <input type="hidden" name="user_id" id="user_id_holder">

    <div class="btn-container">
      <button type="button" id="close_edit_user_modal">Cancel</button>
      <button type="submit">Add User</button>
    </div>

  </form>

</dialog>