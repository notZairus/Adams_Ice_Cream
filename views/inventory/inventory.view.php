<?php require(base_path('views/partials/app-head-top.php')) ?>

<!-- STYLESHEETS -->
<link rel="stylesheet" href="/css/general.css">
<link rel="stylesheet" href="/css/app.css">
<link rel="stylesheet" href="/css/inventory.css">


<!-- SCRIPT -->
<script defer src="/js/functions.js"></script>
<script defer src="/js/inventory.js"></script>

<?php require(base_path('views/partials/app-head-bottom.php')) ?>



<main>
  <!-- MODALS -->
  <?php require(base_path('views/inventory/modals/new-ingredient-modal.php')) ?>
  <?php require(base_path('views/inventory/modals/add-stock-modal.php')) ?>
  <?php require(base_path('views/inventory/modals/edit-ingredient-modal.php')) ?>
  

  <div class="btn-container">
    <button id="show_new_ingredient_modal">New Ingredient</button>
    <button id="show_add_stock_modal">Add Stock</button>
  </div>

  <div class="ingredients-container">
    <h2>Ingredients</h2>
    
    <div class="tables">
      <div class="table-container">
        <table class="ingredients-tbl">
          <thead>
            <tr>
              <th>IID</th>
              <th>Name</th>
              <th>Stock (kg)</th>
              <th>Price (kg)</th>
              <th>Usage per 4 gallons (kg)</th>
              <th></th>
            </tr>
          </thead>
          <tbody class="kg">

            <!-- DATASSSS -->

          </tbody>
        </table>
      </div>  

      <div class="table-container">
        <table class="ingredients-tbl">
          <thead>
            <tr>
              <th>IID</th>
              <th>Name</th>
              <th>Stock (pc)</th>
              <th>Price (per pc)</th>
              <th>Usage per 4 gallons (pc)</th>
              <th></th>
            </tr>
          </thead>
          <tbody class="pcs">

          <!-- DATASSSS -->
            
          </tbody>
        </table>
      </div>  
    </div>          
  </div>

  <div class="restock-container">
    <h2>Ingredient to Restock</h2>

    <div class="table-container">
      <table class="ingredients-tbl">
        <thead>
          <tr>
            <th>IID</th>
            <th>Name</th>
            <th>Stock</th>
            <th>Minimum Stock</th>
          </tr>
        </thead>
        <tbody class="to-restock">
          
        </tbody>
      </table>
    </div>  

</main>



<?php require(base_path('views/partials/app-foot.php')) ?>