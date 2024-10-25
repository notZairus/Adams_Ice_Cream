



<dialog id="update_payment_modal" class="update_payment_modal modal">
  <h2>Update Payment</h2>
  <form action="/orders" method="POST" class="update-payment-form">
    
    <div class="input-field">
      <label for="amount">Amount:</label><br>
      <input type="number" name="amount" id="amount" required pattern="/^\d+$/" min="1">
    </div>

    <div class="btn-container">
      <button type="button" id="close_update_payment_modal">Cancel</button>
      <button type="submit">Confirm</button>
    </div>

    <input type="hidden" name="order_id" value="">
    <input type="hidden" name="_method" value="PATCH">
  </form>

</dialog>
