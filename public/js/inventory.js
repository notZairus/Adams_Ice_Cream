
let show_new_ingredient_modal = document.getElementById('show_new_ingredient_modal')
let close_new_ingredient_modal = document.getElementById('close_new_ingredient_modal')
let new_ingredient_modal = document.getElementById('new_ingredient_modal')


show_new_ingredient_modal.addEventListener('click', () => {
  new_ingredient_modal.showModal();
});

close_new_ingredient_modal.addEventListener('click', () => {
  new_ingredient_modal.close();
  document.getElementById('ingredient_name').value = "";
  document.getElementById('ingredient_price').value = "";
  document.getElementById('ingredient_unit').value = "";
});



let new_ingredient_form = document.querySelector('.new-ingredient-form');
new_ingredient_form.onsubmit = (event) => {
  alert('Ingredient Added Successfully!');
}