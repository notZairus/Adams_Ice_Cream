

<?php require(base_path('views/partials/app-head-top.php')) ?>

<!-- STYLESHEETS -->
<link rel="stylesheet" href="/css/general.css">
<link rel="stylesheet" href="/css/app.css">
<link rel="stylesheet" href="/css/dashboard.css">


<!-- SCRIPTS -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="/js/functions.js"></script>
<script defer src="./js/dashboard.js"></script>


<?php require(base_path('views/partials/app-head-bottom.php')) ?>


<!-- MODALS -->
<?php require(base_path('views/app/modals/message-modal.php')) ?>
<?php require(base_path('views/app/modals/confirmation-modal.php')) ?>

<?php require(base_path('views/dashboard/modals/show-recent-orders.php')) ?>
<?php require(base_path('views/inventory/modals/add-stock-modal.php')) ?>
<?php require(base_path('views/order/modals/add-order-modal.php')) ?>


<main>

  <div class="grid-item sales-stats-container">
    <div class="h1-container">
      <h1>Sales Chart</h1>
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

  <div class="grid-item sales-amount-container">
    <h1>Sales Amount</h1>
    <div class="amount-container">
      <div class="cost-container">
        <h2>Cost</h2>
        <p></p>
      </div>
      <div class="revenue-container">
        <h2>Revenue</h2>
        <p></p>
      </div>
      <div class="profit-container">
        <h2>Profit</h2>
        <p></p>
      </div>
    </div>
  </div>

  <div class="grid-item top-selling-flavor-container">
    <h1>Top Selling Flavors</h1>
    <div class="flavor-container" id="flavor_container">
      <!-- DATASSSSS -->

    </div>
  </div>

  <div class="grid-item quick-controls-container">
    <h1>Quick Controls</h1>
    <div class="quick-cotrols-btn-container" id="qc_show_recent_orders">
      <button class="quick-control-btn">
        <div class="icon-container">
          <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" clip-rule="evenodd" d="M22 12c0 5.523-4.477 10-10 10S2 17.523 2 12 6.477 2 12 2s10 4.477 10 10zm-4.581 3.324a1 1 0 0 0-.525-1.313L13 12.341V6.5a1 1 0 0 0-2 0v6.17c0 .6.357 1.143.909 1.379l4.197 1.8a1 1 0 0 0 1.313-.525z" fill="white"/></svg>
        </div><div>
          <p>Show<br>Recent Orders</p>
        </div>
      </button>
      <button class="quick-control-btn" id="qc_add_stock_btn">
        <div class="icon-container">
          <svg fill="white" xmlns="http://www.w3.org/2000/svg" id="Layer_1" data-name="Layer 1" viewBox="0 0 24 24"><path d="M11,9.401l-2.175,3.624c-.482,.804-1.458,1.165-2.347,.868l-5.081-1.694c-1.23-.41-1.764-1.854-1.097-2.965l1.7-2.834,9,3Zm2,0l2.175,3.624c.482,.804,1.458,1.165,2.347,.868l5.118-1.706c1.211-.404,1.737-1.825,1.08-2.92l-1.72-2.866-9,3Zm-2.46,4.654c-.742,1.236-2.044,1.945-3.415,1.945-.425,0-.856-.067-1.28-.209l-3.845-1.281v6.491l9,3V13.288l-.46,.766Zm7.615,1.736c-.424,.142-.855,.209-1.28,.209-1.371,0-2.673-.708-3.415-1.945l-.46-.766v10.712l9-3v-6.491l-3.845,1.282ZM12,7.627l6.386-2.129-3.912-3.912-5.15,5.149,2.676,.892Zm-4.798-1.599L11.86,1.371,10.525,.036,5.2,5.36l2.002,.667Z"/></svg>
        </div>
        <div>
          <p>Add<br>Stock</p>
        </div>
      </button>
      <button class="quick-control-btn" id="qc_add_order_btn">
        <div class="icon-container">
          <svg fill="white" xmlns="http://www.w3.org/2000/svg" id="Layer_1" data-name="Layer 1" viewBox="0 0 24 24">
            <path d="M19,0c-2.761,0-5,2.239-5,5s2.239,5,5,5,5-2.239,5-5S21.761,0,19,0Zm1.293,7.707l-2.293-2.293V2h2v2.586l1.707,1.707-1.414,1.414Zm-11.293,14.293c0,1.105-.895,2-2,2s-2-.895-2-2,.895-2,2-2,2,.895,2,2Zm12.835-7H5.654l.131,1.116c.059,.504,.486,.884,.993,.884h13.222v2H6.778c-1.521,0-2.802-1.139-2.979-2.649L2.215,2.884c-.059-.504-.486-.884-.993-.884H0V0H1.222c1.521,0,2.802,1.139,2.979,2.649l.041,.351H12.294c-.189,.634-.294,1.305-.294,2,0,3.866,3.134,7,7,7,1.273,0,2.462-.345,3.49-.938l-.655,3.938Zm-2.835,7c0,1.105-.895,2-2,2s-2-.895-2-2,.895-2,2-2,2,.895,2,2Z"/>
          </svg>
        </div>
        <div>
          <p>Add<br>Order</p>
        </div>
      </button>

      <?php if($_SESSION['user_role'] == "Owner") : ?>
        
        <button class="quick-control-btn" id="qc_add_flavor_btn">
          <div class="icon-container">
            <svg fill="white" viewBox="0 0 32 32" version="1.1" xml:space="preserve" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
              <style type="text/css">
                .st0{stroke:#231F20;stroke-width:2;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:10;}
              </style>
              <g id="Musik_icon">
                <g>
                  <path d="M28.91,13.58c-0.04-0.09-0.1-0.18-0.17-0.25c-0.02-0.03-0.05-0.06-0.08-0.08c-0.06-0.05-0.13-0.1-0.2-0.14    C28.32,13.04,28.16,13,28,13h-0.02H22h-4.98h-0.5h-0.49h-0.05h-0.5h-0.5H11H4.02H4c-0.17,0-0.33,0.04-0.47,0.11    c-0.11,0.07-0.22,0.15-0.3,0.25c-0.06,0.07-0.1,0.14-0.13,0.22c-0.09,0.18-0.12,0.39-0.08,0.6l2.69,14.37    C5.98,29.97,7.22,31,8.66,31h14.68c1.44,0,2.68-1.03,2.95-2.45l2.69-14.35c0.01-0.05,0.02-0.11,0.02-0.17v-0.06    C28.99,13.83,28.96,13.7,28.91,13.58z"/>
                  <path d="M22.97,7.03C22.82,7.01,22.66,7,22.5,7c-0.17,0-0.33,0.01-0.5,0.02c-0.46,0.04-0.91,0.14-1.34,0.3    c-0.14,0.05-0.27,0.1-0.4,0.16c-0.08,0.03-0.16,0.07-0.23,0.11c-0.07,0.04-0.15,0.08-0.22,0.12c-0.1,0.05-0.2,0.11-0.3,0.17    C19.4,7.95,19.3,8.02,19.2,8.1c-0.1,0.08-0.2,0.16-0.29,0.24c-0.07,0.06-0.14,0.11-0.19,0.17c-0.02,0.01-0.04,0.03-0.05,0.04    c-0.11,0.11-0.21,0.21-0.3,0.32c-0.07,0.08-0.14,0.17-0.21,0.26c-0.08,0.1-0.15,0.2-0.22,0.3c-0.01,0.01-0.02,0.02-0.02,0.03    c-0.07,0.1-0.13,0.21-0.19,0.31c-0.05,0.09-0.1,0.18-0.15,0.27c-0.06,0.11-0.11,0.23-0.16,0.35c-0.01,0.04-0.03,0.09-0.05,0.13    c-0.01,0.03-0.02,0.05-0.03,0.08c-0.01,0.02-0.02,0.04-0.02,0.06c-0.02,0.06-0.04,0.12-0.06,0.18c-0.08,0.25-0.14,0.5-0.18,0.77    c-0.02,0.13-0.04,0.26-0.05,0.39H22h5.98c-0.16-1.79-1.19-3.33-2.65-4.2C24.63,7.36,23.83,7.09,22.97,7.03z"/>
                  <path d="M23.31,5.91l0.03,0.14c0.92,0.12,1.79,0.44,2.55,0.91l2.94-4.41c0.31-0.46,0.18-1.08-0.28-1.38    c-0.46-0.31-1.08-0.18-1.38,0.28L25,4.7l0.93-2.33c0.2-0.51-0.05-1.09-0.56-1.3c-0.51-0.2-1.09,0.04-1.3,0.56l-1.19,2.98    c0.07,0.17,0.14,0.33,0.2,0.5C23.18,5.37,23.25,5.63,23.31,5.91z"/>
                  <path d="M15.89,11.31c0.02,0.14,0.04,0.28,0.06,0.42c0,0.02,0.01,0.05,0.01,0.07c0.01,0.07,0.01,0.14,0.01,0.2h0.05    c0.05-0.64,0.19-1.25,0.42-1.84c0.04-0.11,0.09-0.22,0.14-0.33c0.08-0.19,0.18-0.37,0.28-0.56c0.06-0.11,0.13-0.21,0.19-0.31    c0.04-0.07,0.09-0.14,0.14-0.21c0.09-0.13,0.19-0.26,0.3-0.39c0.01-0.01,0.02-0.03,0.03-0.04c0.08-0.1,0.17-0.19,0.25-0.28    c0.13-0.14,0.27-0.28,0.42-0.41c0.24-0.21,0.5-0.41,0.77-0.58c0.11-0.08,0.23-0.15,0.35-0.21c0.04-0.03,0.09-0.05,0.14-0.08    c0.13-0.07,0.26-0.14,0.4-0.19C20,6.5,20.16,6.44,20.32,6.38c0.63-0.23,1.3-0.36,2-0.37C22.38,6,22.44,6,22.5,6    c0.11,0,0.22,0,0.32,0.01c-0.05-0.25-0.12-0.49-0.21-0.73C21.71,2.77,19.32,1,16.5,1c-3.08,0-5.67,2.16-6.33,5.04    c1.18,0.11,2.29,0.54,3.22,1.26C14.7,8.27,15.59,9.69,15.89,11.31z"/>
                  <path d="M14.98,12c-0.02-0.17-0.05-0.34-0.08-0.51c-0.25-1.37-1-2.57-2.1-3.39c-0.81-0.62-1.76-0.98-2.78-1.07    C9.85,7.01,9.68,7,9.5,7c-2.86,0-5.22,2.2-5.47,5H11H14.98z"/>
                </g>
              </g>
            </svg>
          </div>
          <div>
            <p>Add<br>Flavor</p>
          </div>
        </button>

      <?php endif ?>

    </div>
  </div>

  <div class="grid-item low-stock-ingredients-container">
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