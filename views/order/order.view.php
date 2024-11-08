<?php require(base_path('views/partials/app-head-top.php')) ?>

<!-- STYLESHEETS -->
<link rel="stylesheet" href="/css/general.css">
<link rel="stylesheet" href="/css/app.css">
<link rel="stylesheet" href="./css/order.css">

<!-- SCRIPTS -->
<script defer src="/js/functions.js"></script>
<script defer src="/js/order.js"></script>


<?php require(base_path('views/partials/app-head-bottom.php')) ?>


<!-- MODALS -->
<?php require(base_path('views/order/modals/add-order-modal.php')) ?>
<?php require(base_path('views/order/modals/update-payment-modal.php'))  ?>


<main>
  <div class="btn-container">
    <div>
      
      <button class="add-order-btn" id="show_add_order_modal" style="margin-right: 8px;">
        Add Order
      </button>

    </div>
    <div>
      <div class="category-btns-container">
        <button class="upcomming-btn selected">Upcomming</button>
        <button class="ongoing-btn">Ongoing</button>
        <button class="finished-btn">Finished</button>
        <button class="cancelled-btn">Cancelled</button>
      </div>
    </div>
  </div>

  <div class="orders-container grid-item">
    <h2 class="category-h2">Upcomming Orders</h2>

    <div class="table-container">
      <table class="orders-tbl">
        <thead>
          <tr height="60px">
            <th>Order ID</th>
            <th>Customer Name</th>
            <th>Contact #</th>
            <th>Size</th>
            <th>Flavor</th>
            <th>Address</th>
            <th>Delivery Date</th>
            <th>Delivery Time</th>
            <th>Price</th>
            <th>Payment</th>
            <th>Balance</th>
            <th width="120px"></th>
          </tr>
        </thead>
        <tbody>

        <!-- DATASSSS -->
          
        </tbody>
      </table>
    </div>  
  
  </div>
</main>

<?php require(base_path('views/partials/app-foot.php')) ?>