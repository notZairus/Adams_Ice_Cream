


<dialog id="add_order_modal" class="add_order_modal modal">

  <div>
    <form action="/orders" method="POST" class="add-order-form" id="add_order_form">
      <div class="customer-info">
        <h2>Customer Info</h2>
        <div>
          <div class="input-field">
            <label for="name">Full Name: </label>
            <br>
            <input type="text" id="name" name="name" min="7" required>
          </div>

          <div class="input-field">
            <label for="contact_info">Contact Info: </label>
            <br>
            <input type="text" id="contact_info" name="contact_info" pattern="^(09\d{9})$" required placeholder="09XXXXXXXXX">
          </div>

          <div class="input-field">
            <label for="email">Email: </label>
            <br>
            <input type="email" id="email" name="email">
          </div>
        </div>
      </div>

      <div class="order-info">
        <h2>Order Info</h2>
        <div>
          <div class="input-field">
            <label for="flavor">Flavor: </label>
            <br>
            <select name="flavor" id="flavor" required>
            </select>
          </div>

          <div class="input-field">
            <label for="size">Size: </label>
            <br>
            <select name="size" id="size" required>
              <option value="4">4 gallons (₱ 1400)</option>
              <option value="8">8 gallons (₱ 2700)</option>
            </select>
          </div>

          <div class="input-field">
            <label for="delivery_adress">Delivery Address: </label>
            <br>
            <input type="text" id="delivery_adress" name="delivery_adress" min="12" required>
          </div>

          <div class="input-field">
            <label for="delivery_date">Delivery Date and Time: </labe l>
            <br>
            <div class="datetime-field">
              <input type="date" id="delivery_date" name="delivery_date" required>
              <input type="time" id="delivery_time" name="delivery_time" min="06:00" max="19:00" required>
            </div>
          </div>

          <div class="input-field" style="margin-top: 12px;">
            <label for="payment">Initial Payment: </label>
            <br>  
            <input type="number" id="payment" name="payment" pattern="/^\d+$/" min="0" required>
          </div>

          <div class="btn-container">
            <button type="button" id="close_add_order_modal">Close</button>
            <button type="submit" id="add_order_btn">Add Order</button>
          </div>

        </div>
      </div>
    </form>
  </div>

  <div class="upcomming-order-div">
    <h2>Orders</h2>

    <div class="upcomming-order-container" id="upcomming_order_container">
      
    </div>

    <div class="btn-container">
      <button id="confirm_orders">Confirm Order</button>
    </di

  </div>

</dialog>
