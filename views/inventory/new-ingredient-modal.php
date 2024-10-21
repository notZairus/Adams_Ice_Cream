

<dialog id="new_ingredient_modal" class="new_ingredient_modal modal">
  <h2>Add Ingredient</h2>
  <form action="/inventory" method="POST" class="new-ingredient-form">
    <div class="text-field">
      <label for="ingredient_name">Name:</label><br>
      <input type="text" name="ingredient_name" id="ingredient_name" required>
    </div>

    <div class="text-field">
      <label for="ingredient_reminder">Stock Reminder:</label><br>
      <input type="number" name="ingredient_reminder" id="ingredient_reminder" required pattern="/^\d+$/" min="3">
    </div>
    
    <div class="text-field">
      <label for="ingredient_price">Price:</label><br>
      <input type="number" name="ingredient_price" id="ingredient_price" required pattern="/^\d+$/" min="0">
    </div>
    
    <div class="text-field">
      <label for="ingredient_unit">Unit:</label><br>
      <select name="ingredient_unit" id="ingredient_unit" required>
        <option value="kg">By Kilograms</option>
        <option value="pcs">By Pieces</option>
      </select>
    </div>

    <div class="btn-container">
      <button type="button" id="close_new_ingredient_modal">Cancel</button>
      <button type="submit">Confirm</button>
    </div>

    <input type="hidden" name="action" value="add_ingredient">
  </form>
</dialog>
