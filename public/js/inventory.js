
var ingredients;

document.addEventListener('DOMContentLoaded', async (event) => {
  ingredients = await getAllIngredients();
  displayIngredients(ingredients);
  displayToRestocks(ingredients);
});

async function getAllIngredients() {
  let response = await fetch('apis/inventory/get-ingredients.php', {
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

  if (ingredient.ingredient_unit == "kg") {
    d3.textContent = isNaN(ingredient.ingredient_stock) ? 0 + " kg": ingredient.ingredient_stock + " kg";
  } else {
    d3.textContent = isNaN(ingredient.ingredient_stock) ? 0 + " pcs": ingredient.ingredient_stock + " pcs";
  }
  tr.appendChild(d3);

  let d4 = document.createElement('td');
  d4.textContent = "₱ " + ingredient.ingredient_price;
  tr.appendChild(d4);

  let d5 = document.createElement('td');
  d5.textContent = ingredient.ingredient_unit == "kg" ? ingredient.ingredient_usage_per_4_gallons + " kg" : ingredient.ingredient_usage_per_4_gallons + " pcs";
  tr.appendChild(d5);

  let d6 = document.createElement('td');
  tr.appendChild(d6);

  let div = document.createElement('div');
  div.classList.add('ingredient-operation-container');
  div.classList.add('gap8');
  d6.appendChild(div);

  let editBtn = document.createElement('button');
  editBtn.classList.add('edit-ingredient-btn');
  editBtn.classList.add('show_edit_ingredient_modal');
  editBtn.classList.add('btn');
  editBtn.classList.add('primary');
  editBtn.dataset.ingredient_id = ingredient.ingredient_id;
  editBtn.textContent = 'Edit';
  attachEvent(editBtn, editIngredient);
  div.appendChild(editBtn);

  const form = document.createElement('form');
  form.setAttribute('action', '/inventory');
  form.setAttribute('method', 'POST');
  form.classList.add('delete_ingredient_form');
  form.addEventListener('submit', async (e) => {
    e.preventDefault();
    let confirmed = await showConfirmationModal('Delete the selected ingredient? ');
    await showMessageModal('Ingredient deleted successfully.');
    if (confirmed) form.submit();
  })
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
  deleteButton.classList.add('btn');
  deleteButton.classList.add('danger');
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
      stockCell.textContent = ingredient.ingredient_unit == "kg" 
        ? isNaN(ingredient.ingredient_stock) ? 0 + " kg": ingredient.ingredient_stock + " kg"
        : isNaN(ingredient.ingredient_stock) ? 0 + " pcs": ingredient.ingredient_stock + " pcs";
      tr.appendChild(stockCell);

      const reminderCell = document.createElement('td');
      reminderCell.textContent = ingredient_unit == "kg" 
        ? ingredient.ingredient_reminder.toFixed(2) + " kg" 
        : ingredient.ingredient_reminder.toFixed(2) + " pcs" ;
      tr.appendChild(reminderCell);

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

new_ingredient_modal.querySelector('.new-ingredient-form').addEventListener('submit', async (e) => {
  e.preventDefault();

  let form = e.target;
  let formData = new FormData(form);

  closeDialog(new_ingredient_modal);

  let dataToSend = {
    ingredient_name: formData.get('ingredient_name'),
    ingredient_price: formData.get('ingredient_price'),
    ingredient_reminder: formData.get('ingredient_reminder'),
    ingredient_unit: formData.get('ingredient_unit'),
    ingredient_usage_per_4_gallons: formData.get('ingredient_usage_per_4_gallons'),
  }

  await fetch('apis/inventory/add-new-ingredient.php', {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json',
    },
    body: JSON.stringify(dataToSend),
  });

  await showMessageModal('New ingredient added successfully!');

  location.reload();
})

//ADD STOCK
//ADD STOCK
//ADD STOCK

let add_stock_modal = document.getElementById('add_stock_modal')

document.getElementById('show_add_stock_modal').addEventListener('click', () => {
  let select = add_stock_modal.querySelector('#ingredient_id');

  while (select.firstChild) {
    select.removeChild(select.firstChild);
  }
  
  ingredients.forEach(ingredient => {
    const option = document.createElement('option');
    option.value = ingredient.ingredient_id;
    option.textContent = ingredient.ingredient_name;
    select.appendChild(option);
  })

  
  add_stock_modal.querySelector('#request_from').value = "/inventory";

  showDialog(add_stock_modal);
})

document.getElementById('close_add_stock_modal').onclick = () => {
  closeDialog(add_stock_modal);
};

document.querySelector('.add-stock-form').onsubmit = (event) => {
  showMessageModal("Stock Sucessfully Added!");
}


//EDIT INGREDIENT
//EDIT INGREDIENT
//EDIT INGREDIENT

let edit_ingredient_modal = document.getElementById('edit_ingredient_modal');

function editIngredient(event) {
  target = event.target;

  const row = target.closest('tr'); 

  edit_ingredient_modal.querySelector('#ingredient_id').value = row.querySelector('td:nth-child(1)').textContent;
  edit_ingredient_modal.querySelector('#ingredient_name').value = row.querySelector('td:nth-child(2)').textContent;
  edit_ingredient_modal.querySelector('#ingredient_price').value = row.querySelector('td:nth-child(4)').textContent.replace("₱ ", "");

  edit_ingredient_modal.querySelector('#ingredient_stock').value = row.querySelector('td:nth-child(3)').textContent.endsWith(" kg") 
  ? row.querySelector('td:nth-child(3)').textContent.replace(" kg", "") 
  : row.querySelector('td:nth-child(3)').textContent.replace(" pcs", "");

  edit_ingredient_modal.querySelector('#ingredient_usage_per_4_gallons').value = row.querySelector('td:nth-child(5)').textContent.endsWith(" kg") 
  ? row.querySelector('td:nth-child(5)').textContent.replace(" kg", "") 
  : row.querySelector('td:nth-child(5)').textContent.replace(" pcs", "");

  showDialog(edit_ingredient_modal);
}

document.querySelectorAll('.show_edit_ingredient_modal').forEach(btn => {
  btn.addEventListener('click', editIngredient);
})

edit_ingredient_modal.querySelector('.edit-ingredient-form').addEventListener('submit', async (e) => {
  e.preventDefault();

  let form = e.target;
  let formData = new FormData(form);

  closeDialog(edit_ingredient_modal);

  let dataToSend = {
    ingredient_id: formData.get('ingredient_id'),
    ingredient_name: formData.get('ingredient_name'),
    ingredient_stock: formData.get('ingredient_stock'),
    ingredient_price: formData.get('ingredient_price'),
    ingredient_unit: formData.get('ingredient_unit'),
    ingredient_usage_per_4_gallons: formData.get('ingredient_usage_per_4_gallons'),
  }

  await fetch('apis/inventory/edit-ingredient.php', {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json',
    },
    body: JSON.stringify(dataToSend),
  });

  await showMessageModal('Ingredient updated successfully !');

  location.reload();
});

document.getElementById('close_edit_ingredient_modal').onclick = () => {
  closeDialog(edit_ingredient_modal);
}


