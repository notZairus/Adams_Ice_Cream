
//NEW INGREDIENT
//NEW INGREDIENT
//NEW INGREDIENT

let show_new_ingredient_modal = document.getElementById('show_new_ingredient_modal')
let close_new_ingredient_modal = document.getElementById('close_new_ingredient_modal')
let new_ingredient_modal = document.getElementById('new_ingredient_modal')


show_new_ingredient_modal.onclick = () => {
  new_ingredient_modal.showModal();
};

close_new_ingredient_modal.onclick = () => {
  new_ingredient_modal.close();
  document.getElementById('ingredient_name').value = "";
  document.getElementById('ingredient_price').value = "";
  document.getElementById('ingredient_unit').value = "";
};

document.querySelector('.new-ingredient-form').onsubmit = (event) => {
  alert('Ingredient Added Successfully!');
}


//ADD STOCK
//ADD STOCK
//ADD STOCK

let show_add_stock_modal = document.getElementById('show_add_stock_modal')
let close_add_stock_modal = document.getElementById('close_add_stock_modal')
let add_stock_modal = document.getElementById('add_stock_modal')


show_add_stock_modal.onclick = () => {
  add_stock_modal.showModal();
}

close_add_stock_modal.onclick = () => {
  add_stock_modal.close();
  document.getElementById('ingredient_id').value = "";
  document.getElementById('new_stocks').value = "";
  document.getElementById('ingredient_unit').value = "";
};

document.querySelector('.add-stock-form').onsubmit = (event) => {
  alert("Stock Sucessfully Added!");
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