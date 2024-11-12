
const add_user_modal = document.getElementById('add_user_modal');
document.getElementById('show_add_user_modal').addEventListener('click', (e) => {
  showDialog(add_user_modal);
})

document.getElementById('close_add_user_modal').addEventListener('click', (e) => {
  closeDialog(add_user_modal);
})


const edit_user_modal = document.getElementById('edit_user_modal');
document.querySelectorAll('.edit-account').forEach(btn => {
  btn.addEventListener('click', (e) => {
    let row = e.currentTarget.closest('tr');

    edit_user_modal.querySelector('#user_id_holder').value = row.querySelector('td:nth-child(1)').textContent;
    edit_user_modal.querySelector('#edfullname').value = row.querySelector('td:nth-child(2)').textContent;
    edit_user_modal.querySelector('#edusername').value = row.querySelector('td:nth-child(4)').textContent;
    edit_user_modal.querySelector('#edemail').value = row.querySelector('td:nth-child(5)').textContent;

    showDialog(edit_user_modal);
  })
})

document.getElementById('close_edit_user_modal').addEventListener('click', () => {
  closeDialog(edit_user_modal);
})


let delete_user_btns = document.querySelectorAll('.delete-account');
delete_user_btns.forEach(btn => {
  btn.addEventListener('click', async (e) => {
    let confirmed = await showConfirmationModal('Are you sure you want to delete this user?');
    if (! confirmed) return;

    let form = e.target.parentElement;
    form.submit();
  })
});



let confirm_password_modal = document.getElementById('confirm_password_modal');

let transfer_ownership_btns = document.querySelectorAll('.transfer-ownership');
transfer_ownership_btns.forEach(btn => {
  btn.addEventListener('click', async (e) => {
    confirm_password_modal.querySelector('#user_id_hidden_input').value = btn.dataset.user_id;
    // console.log(confirm_password_modal);
    showDialog(confirm_password_modal);
  })
})


document.getElementById('close_confirm_password_modal').addEventListener('click', (e) => {
  closeDialog(confirm_password_modal);
})


confirm_password_modal.querySelector('#confirm_password_btn').addEventListener('click', async (e) => {
  let pwd = confirm_password_modal.querySelector('input[type="password"]').value;
  confirm_password_modal.querySelector('input[type="password"]').value = "";

  //check password
  let response = await fetch('apis/account/check-owner-password.php', {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json'
    },
    body: JSON.stringify({
      password: pwd,
    })
  });

  let isCorrect = await response.json();

  if (! isCorrect) {
    showMessageModal('Incorrect Password.');
    return;
  }

  let confirmed = await showConfirmationModal('Are you sure?');
  if (! confirmed) return;

  
  console.log(confirm_password_modal);

  let form = confirm_password_modal.querySelector('form');

  console.log(form); 

  console.log(form.querySelector('#user_id_hidden_input').value);

  form.submit();
})