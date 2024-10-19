
//NEW INGREDIENT
//NEW INGREDIENT
//NEW INGREDIENT

let new_ingredient_modal = document.getElementById('new_ingredient_modal')

document.getElementById('show_new_ingredient_modal').addEventListener('click', () => {
  showDialog(new_ingredient_modal);
})

document.getElementById('close_new_ingredient_modal').onclick = () => {
  closeDialog(new_ingredient_modal);
};

document.querySelector('.new-ingredient-form').onsubmit = (event) => {
  alert('Ingredient Added Successfully!');
}


//ADD STOCK
//ADD STOCK
//ADD STOCK

let add_stock_modal = document.getElementById('add_stock_modal')

document.getElementById('show_add_stock_modal').addEventListener('click', () => {
  showDialog(add_stock_modal);
})

document.getElementById('close_add_stock_modal').onclick = () => {
  closeDialog(add_stock_modal);
};

document.querySelector('.add-stock-form').onsubmit = (event) => {
  alert("Stock Sucessfully Added!");
}



//EDIT INGREDIENT
//EDIT INGREDIENT
//EDIT INGREDIENT

let edit_ingredient_modal = document.getElementById('edit_ingredient_modal');

document.querySelectorAll('.show_edit_ingredient_modal').forEach(btn => {
  
  btn.addEventListener('click', (event) => {
    target = event.target;

    const row = target.closest('tr'); 

    edit_ingredient_modal.querySelector('#ingredient_name').value = row.querySelector('td:nth-child(2)').textContent;
    edit_ingredient_modal.querySelector('#ingredient_stock').value = row.querySelector('td:nth-child(3)').textContent;
    edit_ingredient_modal.querySelector('#ingredient_price').value = row.querySelector('td:nth-child(4)').textContent;
    edit_ingredient_modal.querySelector('#ingredient_unit').value = row.querySelector('td:nth-child(5)').textContent;
    edit_ingredient_modal.querySelector('#ingredient_id').value = row.querySelector('td:nth-child(1)').textContent;

    showDialog(edit_ingredient_modal);
  })

})

document.getElementById('close_edit_ingredient_modal').onclick = () => {
  closeDialog(edit_ingredient_modal);
}



//DELETE INGREDIENT
//DELETE INGREDIENT
//DELETE INGREDIENT

let deleteForms = document.querySelectorAll('.delete_ingredient_form');

Array.from(deleteForms).forEach(deleteForm => {
  deleteForm.onsubmit = (event) => {
    let confirmed = confirm("Delete the selected ingredient? ");
    if (! confirmed) event.preventDefault();
  }
});