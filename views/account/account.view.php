



<?php require(base_path('views/partials/app-head-top.php')) ?>

<!-- STYLESHEETS -->
<link rel="stylesheet" href="/css/general.css">
<link rel="stylesheet" href="/css/app.css">
<link rel="stylesheet" href="/css/flavor.css">
<link rel="stylesheet" href="/css/account.css">

<!-- SCRIPTS -->
<script defer src="/js/functions.js"></script>  
<script defer src="/js/account.js"></script>


<?php require(base_path('views/partials/app-head-bottom.php')) ?>


<!-- MODALS -->
<?php require(base_path('views/account/modals/add-user-modal.php')) ?>

<main>

    <div class="btn-container">
      <button class="add-flavor-btn" id="show_add_user_modal">
        Add User
      </button> 
    </div>

    <div class="flavor-container grid-item">
      <h2 class="category-h2">Users</h2>

      <div class="table-container">
        <table class="flavor-tbl">
          <thead>
            <tr>
              <th>UID</th>
              <th>Username</th>
              <th>Full Name</th>
              <th>Role</th>
              <th width="320px"></th>
            </tr>
          </thead>
          <tbody>

          <?php foreach($users as $user) : ?>

            <tr>
              <td><?= $user['user_id'] ?></td>
              <td><?= $user['username'] ?></td>
              <td><?= $user['user_fullname'] ?></td>
              <td><?= $user['user_role'] ?></td>
              <td style="text-align: left;">
                
                <button class="edit-account" data-user_id="<?= $user['user_id'] ?>">Edit</button>

                <?php if ($user['user_role'] == 'Employee') : ?>

                  <button class="transfer-ownership">Transfer Ownership</button>
                  <form action="/accounts" method="POST" style="display: inline;">
                    <input type="hidden" name="_method" value="DELETE">
                    <input type="hidden" name="user_id" value="<?= $user['user_id'] ?>">
                    <button class="delete-account">Delete</button>
                  </form>

                <?php endif ?>

              </td>
            </tr>

          <?php endforeach ?>
           
          </tbody>
        </table>
      </div>  
    
    </div>

</main>



<?php require(base_path('views/partials/app-foot.php')) ?>