

<dialog id="edit_ingredient_modal" class="edit_ingredient_modal modal">
  <h2>Edit Ingredient</h2>
  <form action="/inventory" method="POST" class="edit-ingredient-form">
    <div class="text-field">
      <label for="ingredient_name">Name:</label><br>
      <input type="text" name="ingredient_name" id="ingredient_name"  required>
    </div>

    <div class="text-field">
      <label for="ingredient_stock">Stock:</label><br>
      <input type="number" name="ingredient_stock" id="ingredient_stock" required pattern="/^\d+$/" min="0">
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

    <div class="text-field">
      <label for="ingredient_usage_per_4_gallons">4gals usage:</label><br>
      <input type="number" name="ingredient_usage_per_4_gallons" id="ingredient_usage_per_4_gallons" required step="0.1" min="0.5">
    </div>

    <input type="hidden" name="ingredient_id" id="ingredient_id" value="add_ingredient">
    <input type="hidden" name="_method" value="PATCH">

    <div class="btn-container">
      <button type="button" id="close_edit_ingredient_modal">Cancel</button>
      <button type="submit">Confirm</button>
    </div>
  </form>
</dialog>
