<?php require(base_path('views/partials/app-head-top.php')) ?>

<!-- STYLESHEETS -->
<link rel="stylesheet" href="/css/general.css">
<link rel="stylesheet" href="/css/app.css">
<link rel="stylesheet" href="/css/dashboard.css">

<!-- SCRIPTS -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script defer src="./js/dashboard.js"></script>

<?php require(base_path('views/partials/app-head-bottom.php')) ?>

<main>

  <div class="grid-item">
    <div class="h1-container">
      <h1>Sales Stats Overview</h1>
      <div class="toggles-container" id="time-toggles">
        <button id="this_week" class="selected">
          This Week
        </button>
        <button id="this_month">
          This Month
        </button>
        <button id="this_year">
          This Year
        </button>
      </div>
    </div>
    <div class="chart-container">
      <canvas id="myChart"></canvas>
    </div>
  </div>

  <div class="grid-item top-selling-flavor-container">
    <h1>Top Selling Flavors</h1>
    <div class="flavor-container" id="flavor_container">
      <!-- DATASSSSS -->

    </div>
  </div>

  <div class="grid-item">
    <h1>Quick Controls</h1>
  </div>

  <div class="grid-item">
    <h1>Low Stock Ingredients</h1>
    <div class="ingredient-container" id="ingredient_table_container">
      <table>
        <thead>
          <tr>
            <th>Ingredient Name</th>
            <th>Remaining Stock</th>
            <th>Minimum Stock</th>
            <th>Amount Used per 4 Gallons</th>
          </tr>
        </thead>
        <tbody >
        </tbody>
      </table>
    </div>
  </div>

</main>



<?php require(base_path('views/partials/app-foot.php')) ?>