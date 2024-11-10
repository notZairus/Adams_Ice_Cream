
const add_user_modal = document.getElementById('add_user_modal');
document.getElementById('show_add_user_modal').addEventListener('click', (e) => {
  showDialog(add_user_modal);
})

document.getElementById('close_add_user_modal').addEventListener('click', (e) => {
  closeDialog(add_user_modal);
})
