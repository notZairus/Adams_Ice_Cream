



<dialog id="add_stock_modal" class="add_stock_modal modal">
  <h2>Add Stock</h2>
  <form action="/inventory" method="POST" class="add-stock-form">
    
    <div class="text-field">
      <label for="ingredient_id">Ingredient Name:</label><br>
      <select name="ingredient_id" id="ingredient_id" required>

      <!-- DATASSS -->

      </select>
    </div>
    
    <div class="text-field">
      <label for="new_stocks">Count:</label><br>
      <input type="number" name="new_stocks" id="new_stocks" required pattern="/^\d+$/" min="1">
    </div>

    <div class="btn-container">
      <button type="button" id="close_add_stock_modal">Cancel</button>
      <button type="submit">Confirm</button>
    </div>

    <input type="hidden" name="action" value="add_stock">
  </form>
</dialog>
