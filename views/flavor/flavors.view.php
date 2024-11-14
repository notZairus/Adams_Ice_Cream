

<?php require(base_path('views/partials/app-head-top.php')) ?>

<!-- STYLESHEETS -->
<link rel="stylesheet" href="/css/general.css">
<link rel="stylesheet" href="/css/app.css">
<link rel="stylesheet" href="/css/flavor.css">

<!-- SCRIPTS -->
<script defer src="/js/functions.js"></script>
<script defer src="/js/flavors.js"></script>

<?php require(base_path('views/partials/app-head-bottom.php')) ?>

<!-- MODALS -->
<?php require(base_path('views/app/modals/confirmation-modal.php')) ?>

<?php require(base_path('views/flavor/modals/add-flavor-modal.php')) ?>
<?php require(base_path('views/flavor/modals/edit-flavor-modal.php')) ?>

<main>
  <div class="btn-container">
    <div>
      <button class="add-flavor-btn" id="show_add_flavor_modal">
        Add Flavor
      </button> 
    </div>
  </div>

  <div class="flavor-container grid-item">
    <h2 class="category-h2">Available Flavors</h2>

    <div class="table-container">
      <table class="flavor-tbl">
        <thead>
          <tr>
            <th>Flavor ID</th>
            <th>Flavor Name</th>
            <th>Flavor Cost (Pesos)</th>
            <th></th>
          </tr>
        </thead>
        <tbody>

          <?php foreach($flavors as $flavor): ?>
            
            <tr>
              <td><?= $flavor['flavor_id'] ?></td>
              <td><?= $flavor['flavor_name'] ?></td> 
              <td><?= "₱ ". $flavor['flavor_cost'] ?></td>
              <td>
                <div class="order-operation-container">
                  <button class="btn primary edit-flavor-btn show_edit_flavor_modal" id="show_edit_flavor_modal">
                    Edit
                  </button>
                  <form action="/flavors" method="POST" class="delete_flavor_form" style="display:inline">
                    <input type="hidden" name="flavor_id" value="<?= $flavor['flavor_id'] ?>">
                    <button type="button" class="btn danger delete-flavor-btn">
                      Delete
                    </button>
                    <input type="hidden" name="_method" value="DELETE">
                  </form>
                </div>
              </td>
            </tr>

          <?php endforeach ?>
          
        </tbody>
      </table>
    </div>  
  
  </div>



</main>



<?php require(base_path('views/partials/app-foot.php')) ?>