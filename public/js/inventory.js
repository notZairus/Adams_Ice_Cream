
var ingredients;

document.addEventListener('DOMContentLoaded', async (event) => {
  ingredients = await getAllIngredients();
  displayIngredients(ingredients);
  displayToRestocks(ingredients);
});

async function getAllIngredients() {
  let response = await fetch('inventoryAjax/get-ingredients.php', {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json'
    }
  });
  let ingredients = await response.json();

  return ingredients;
}

function displayIngredients(ingredients) {
  let tbodykg = document.querySelector('.ingredients-tbl tbody.kg');
  let tbodypcs = document.querySelector('.ingredients-tbl tbody.pcs');

  ingredients.forEach(ingredient => {
    if (ingredient.ingredient_unit == 'kg') {
      tbodykg.appendChild(createIngredientRow(ingredient))
    } else {
      tbodypcs.appendChild(createIngredientRow(ingredient))
    }
  })
}

function createIngredientRow(ingredient) {
  let tr = document.createElement('tr');

  let d1 = document.createElement('td');
  d1.textContent = ingredient.ingredient_id;
  tr.appendChild(d1);

  let d2 = document.createElement('td');
  d2.textContent = ingredient.ingredient_name;
  tr.appendChild(d2);

  let d3 = document.createElement('td');
  d3.textContent = ingredient.ingredient_stock;
  tr.appendChild(d3);

  let d4 = document.createElement('td');
  d4.textContent = ingredient.ingredient_price;
  tr.appendChild(d4);

  let d5 = document.createElement('td');
  tr.appendChild(d5);

  let div = document.createElement('div');
  div.classList.add('ingredient-operation-container');
  d5.appendChild(div);

  let editBtn = document.createElement('button');
  editBtn.classList.add('edit-ingredient-btn');
  editBtn.classList.add('show_edit_ingredient_modal');
  editBtn.dataset.ingredient_id = ingredient.ingredient_id;
  editBtn.textContent = 'Edit';
  attachEvent(editBtn, editIngredient);
  div.appendChild(editBtn);

  const form = document.createElement('form');
  form.setAttribute('action', '/inventory');
  form.setAttribute('method', 'POST');
  form.classList.add('delete_ingredient_form');
  div.appendChild(form);

  const methodInput = document.createElement('input');
  methodInput.setAttribute('type', 'hidden');
  methodInput.setAttribute('name', '_method');
  methodInput.setAttribute('value', 'DELETE');
  form.appendChild(methodInput);

  const ingredientInput = document.createElement('input');
  ingredientInput.setAttribute('type', 'hidden');
  ingredientInput.setAttribute('name', 'ingredient_id');
  ingredientInput.setAttribute('value', ingredient.ingredient_id);
  form.appendChild(ingredientInput);

  const deleteButton = document.createElement('button');
  deleteButton.classList.add('delete-ingredient-btn');
  deleteButton.textContent = 'Delete';
  form.appendChild(deleteButton);

  return tr;
}

function displayToRestocks(ingredients) {
  let toRestock = document.querySelector('tbody.to-restock');
  
  ingredients.forEach(ingredient => {
    if (ingredient.ingredient_stock <= ingredient.ingredient_reminder) {
      const tr = document.createElement('tr');
      const idCell = document.createElement('td');
      idCell.textContent = ingredient.ingredient_id;
      tr.appendChild(idCell);

      const nameCell = document.createElement('td');
      nameCell.textContent = ingredient.ingredient_name;
      tr.appendChild(nameCell);

      const stockCell = document.createElement('td');
      stockCell.textContent = ingredient.ingredient_stock;
      tr.appendChild(stockCell);

      toRestock.appendChild(tr);
    }
  })
}



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
  let select = document.getElementById('ingredient_id');
  
  ingredients.forEach(ingredient => {
    const option = document.createElement('option'); // Create the option element
    option.value = ingredient.ingredient_id; // Set the value attribute
    option.textContent = ingredient.ingredient_name;
    select.appendChild(option);
  })

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

function editIngredient(event) {
  target = event.target;

  const row = target.closest('tr'); 

  edit_ingredient_modal.querySelector('#ingredient_name').value = row.querySelector('td:nth-child(2)').textContent;
  edit_ingredient_modal.querySelector('#ingredient_stock').value = row.querySelector('td:nth-child(3)').textContent;
  edit_ingredient_modal.querySelector('#ingredient_price').value = row.querySelector('td:nth-child(4)').textContent;
  edit_ingredient_modal.querySelector('#ingredient_unit').value = row.querySelector('td:nth-child(5)').textContent;
  edit_ingredient_modal.querySelector('#ingredient_id').value = row.querySelector('td:nth-child(1)').textContent;

  showDialog(edit_ingredient_modal);
}

document.querySelectorAll('.show_edit_ingredient_modal').forEach(btn => {
  btn.addEventListener('click', editIngredient);
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