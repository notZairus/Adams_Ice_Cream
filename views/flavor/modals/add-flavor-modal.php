
<dialog id="add_flavor_modal" class="add_flavor_modal modal">
  <h2>Add Stock</h2>
  <form action="/flavors" method="POST" class="add-flavor-form">
    
    <div class="text-field">
      <label for="flavor_name">Flavor Name:</label><br>
      <input type="text" name="flavor_name" id="flavor_name" required>
    </div>
    
    <div class="text-field">
      <label for="flavor_cost">Flavor Cost:</label><br>
      <input type="number" name="flavor_cost" id="flavor_cost" required pattern="/^\d+$/" min="1">
    </div>

    <div class="btn-container">
      <button type="button" id="close_add_flavor_modal">Cancel</button>
      <button type="submit">Confirm</button>
    </div>

  </form>
</dialog>