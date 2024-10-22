

let add_flavor_modal = document.getElementById('add_flavor_modal');

document.getElementById('show_add_flavor_modal').addEventListener('click', () => {
  showDialog(add_flavor_modal);
})

document.getElementById('close_add_flavor_modal').addEventListener('click', () => {
  closeDialog(add_flavor_modal);
})


let edit_flavor_modal = document.getElementById('edit_flavor_modal');

Array.from(document.querySelectorAll('.show_edit_flavor_modal')).forEach(btn => {
  btn.addEventListener('click', editFlavor);
})

function editFlavor(event) {
  target = event.target;

  const row = target.closest('tr'); 

  edit_flavor_modal.querySelector('#flavor_name').value = row.querySelector('td:nth-child(2)').textContent;
  edit_flavor_modal.querySelector('#flavor_cost').value = row.querySelector('td:nth-child(3)').textContent;
  edit_flavor_modal.querySelector('#flavor_id').value = row.querySelector('td:nth-child(1)').textContent;

  showDialog(edit_flavor_modal);
}

document.getElementById('close_edit_flavor_modal').addEventListener('click', () => {
  closeDialog(edit_flavor_modal);
})



let deleteForms = document.querySelectorAll('.delete_flavor_form');

Array.from(deleteForms).forEach(deleteForm => {
  deleteForm.onsubmit = (event) => {
    let confirmed = confirm("Delete the selected ingredient? ");
    if (! confirmed) event.preventDefault();
  }
});