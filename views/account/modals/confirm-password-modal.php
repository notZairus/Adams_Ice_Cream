

<dialog id="confirm_password_modal" class="confirm-password modal" style="flex-direction: column; gap: 8px;">
  <h2>Confirm Password</h2>

  <form action="/accounts/transfer-ownership" method="POST" id="confirm_password_form">

    <input type="hidden" name="user_id" id="user_id_hidden_input">
    <input type="hidden" name="_method" value="PATCH">

    <div class="text-field">
      <label for="password">Password:</label><br>
      <input type="password" name="password" requiredo>
    </div>

    <div class="btn-container">
      <button type="button" id="close_confirm_password_modal" class="btn secondary">Cancel</button>
      <button type="button" class="btn primary" id="confirm_password_btn">Confirm</button>
    </div>

  </form>
</dialog>