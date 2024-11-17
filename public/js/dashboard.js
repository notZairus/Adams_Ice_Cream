
let transactions;
let flavors;
let ingredients;
let orders;

let currentChart1 = null;


document.addEventListener('DOMContentLoaded', async (event) => {
  transactions = await getAllTransactions();
  flavors = await getAllFlavors();
  ingredients = await getAllIngredients();
  orders = await getAllOrders();

  displayThisWeek(transactions);
  displayTopSellingFlavors(flavors);
  displayLowStockIngredients(ingredients);
});

//======================================================================================================================================

// TRANSACTION STATS
// TRANSACTION STATS
// TRANSACTION STATS

async function getAllOrders() {
  let response = await fetch('apis/dashboard/get-all-orders.php', {
    method: 'POST',
    headers: {
      "Content-Type": "application/json"
    }
  })

  let result = await response.json();
  return result;
}

async function getAllTransactions() {
  let response = await fetch('apis/dashboard/get-all-transactions.php', {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json'
    }
  });

  let result = await response.json();
  return result;
}

function displayThisWeek(transactions) {
  let transactionsArray = Array.from(transactions);

  function startOfWeek() {
    const now = new Date();
    const dayOfWeek = now.getDay(); // 0 is Sunday, 6 is Saturday
    const date = new Date(now);
    date.setDate(now.getDate() - dayOfWeek); // Move to start of the week (Sunday)
    date.setHours(0, 0, 0, 0);
    return date;
  }

  let transactionThisWeek = transactionsArray.filter(transaction => {
    let transactionDate = new Date(transaction.transaction_datetime);
    return transactionDate >= startOfWeek() && transactionDate <= new Date();
  })

  function mapTransaction(transactionThisWeek) {
    let days = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
  
    let mappedTransactions = {
      expenses: new Map([
        ['Sunday', 0],
        ['Monday', 0],
        ['Tuesday', 0],
        ['Wednesday', 0],
        ['Thursday', 0],
        ['Friday', 0],
        ['Saturday', 0]
      ]),
      incomes: new Map([
        ['Sunday', 0],
        ['Monday', 0],
        ['Tuesday', 0],
        ['Wednesday', 0],
        ['Thursday', 0],
        ['Friday', 0],
        ['Saturday', 0]
      ])
    }

    transactionThisWeek.forEach(transaction => {
      let date = new Date(transaction.transaction_datetime);
      let day = date.getDay();

      if (transaction.transaction_type == "INCOME") {
        mappedTransactions.incomes.set(days[day], mappedTransactions.incomes.get(days[day]) + parseFloat(transaction.income_amount));
      } else {
        mappedTransactions.expenses.set(days[day], mappedTransactions.expenses.get(days[day]) + parseFloat(transaction.expense_amount));
      }
    });

    return mappedTransactions;
  }

  let mappedTransactions = mapTransaction(transactionThisWeek);

  displayChart(mappedTransactions);
  displaySales(mappedTransactions);
}

function displayThisMonth(transactions) {
  let transactionsArray = Array.from(transactions);

  //helper function to get the start of the month
  function startOfMonth() {
    const date = new Date();
    date.setDate(1); // Set to first day of the month
    date.setHours(0, 0, 0, 0);
    return date;
  }

  //filter transactions that are in this month
  let transactionThisMonth = transactionsArray.filter(transaction => {
    let transactionDate = new Date(transaction.transaction_datetime);
    return transactionDate >= startOfMonth() && transactionDate <= new Date();
  })

  //assign transactions on each day that has it
  function mapTransaction(transactionThisMonth) {
    let now = new Date();
    let daysInMonth = new Date(now.getFullYear(), now.getMonth() + 1, 0).getDate();
    
    let mappedTransactions = {
      expenses: new Map([
      ]),
      incomes: new Map([
      ])
    };

    for (let i = 0; i < daysInMonth; i++) {
      mappedTransactions.expenses.set(i + 1, 0);
      mappedTransactions.incomes.set(i + 1, 0);
    }

    transactionThisMonth.forEach(transaction => {
      let date = new Date(transaction.transaction_datetime);
      let day = date.getDate();

      if (transaction.transaction_type == "INCOME") {
        mappedTransactions.incomes.set(day, mappedTransactions.incomes.get(day) + parseFloat(transaction.income_amount));
      } else {
        mappedTransactions.expenses.set(day, mappedTransactions.expenses.get(day) + parseFloat(transaction.expense_amount));
      }
    });

    return mappedTransactions;

  }

  let mappedTransactions = mapTransaction(transactionThisMonth);

  let days = Array.from(mappedTransactions.expenses.keys()).map(day => {
    let months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
    let now = new Date();
    return `${months[now.getMonth()]}${day}`;
  })

  displayChart(mappedTransactions);
  displaySales(mappedTransactions);

}

function displayThisYear(transactions) {
  let transactionsArray = Array.from(transactions);

  function startOfYear() {
    const date = new Date();
    date.setMonth(0, 1); // January 1st
    date.setHours(0, 0, 0, 0);
    return date;
  }

  let transactionThisYear = transactionsArray.filter(transaction => {
    let transactionDate = new Date(transaction.transaction_datetime);
    return transactionDate >= startOfYear() && transactionDate <= new Date();
  })
  
  function mapTransaction(transactionThisYear) {
    let now = new Date();
    let months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
    let mappedTransactions = {
      expenses: new Map([
      ]),
      incomes: new Map([
      ])
    };

    months.forEach(month => {
      mappedTransactions.expenses.set(month, 0);
      mappedTransactions.incomes.set(month, 0);
    });

    transactionThisYear.forEach(transaction => {
      let date = new Date(transaction.transaction_datetime);
      let monthIndex = date.getMonth();

      if (transaction.transaction_type == "INCOME") {
        mappedTransactions.incomes.set(months[monthIndex], mappedTransactions.incomes.get(months[monthIndex]) + parseFloat(transaction.income_amount));
      } else {
        mappedTransactions.expenses.set(months[monthIndex], mappedTransactions.expenses.get(months[monthIndex]) + parseFloat(transaction.expense_amount));
      }
      
    });

    return mappedTransactions;
  };

  let mappedTransactions = mapTransaction(transactionThisYear);

  displayChart(mappedTransactions);
  displaySales(mappedTransactions);
}

function displayChart(transactions) {
  
  if (currentChart1) currentChart1.destroy();

  let mappedTransactions = transactions;

  const myChart = document.getElementById('myChart');
  currentChart1 = new Chart(myChart, {
    type: 'line',
    data: {
      labels: Array.from(mappedTransactions.incomes.keys()),
      datasets: [
        {
          label: "Incomes",
          data: Array.from(mappedTransactions.incomes.values()),
          borderWidth: 1,
          borderColor: '#334259',
          backgroundColor: '#334259'
        },
        {
          label: "Expenses",
          data: Array.from(mappedTransactions.expenses.values()),
          borderWidth: 1,
          borderColor: 'red',
          backgroundColor: 'red'
        },
      ]
    },
    options: {
      scales: {
        y: {
          beginAtZero: true
        }
      }
    }
  });

}

function displaySales(transactions) {
  let cost = 0;
  let revenue = 0;

  Array.from(transactions.incomes.values()).forEach(income => {
    revenue += parseFloat(income);
  })

  Array.from(transactions.expenses.values()).forEach(expenses => {
    cost += parseFloat(expenses);
  })

  profit = revenue - cost; 

  let sales_amount_container = document.querySelector('.sales-amount-container');

  sales_amount_container.querySelector('.cost-container p').textContent = '₱ ' + cost; 
  sales_amount_container.querySelector('.revenue-container p').textContent = '₱ ' + revenue; 
  sales_amount_container.querySelector('.profit-container p').textContent = profit > 0 ? '₱ ' + profit : '₱' + 0; 
}

//======================================================================================================================================


//======================================================================================================================================

// FLAVORS
// FLAVORS
// FLAVORS
  
async function getAllFlavors() {
  let response = await fetch('apis/dashboard/get-all-flavors.php', {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json'
    }
  });

  let result = await response.json();
  return Array.from(result).sort((a, b) => b.flavor_order_count - a.flavor_order_count);
}

function displayTopSellingFlavors(flavors) {
  let flavor_container = document.getElementById('flavor_container');

  flavors.forEach(flavor => {
    let a = document.createElement('a');
    a.classList.add('flavor');
    a.href = `https://en.wikipedia.org/wiki/${flavor.flavor_name}`;
    a.target = "_blank";
    a.textContent = flavor.flavor_name;

    flavor_container.appendChild(a);
  });
}

//======================================================================================================================================


//======================================================================================================================================

// INGREDIENTS
// INGREDIENTS
// INGREDIENTS
  
async function getAllIngredients() {
  let response = await fetch('apis/dashboard/get-all-ingredients.php', {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json'
    }
  });

  let result = await response.json();
  return result;
}

function displayLowStockIngredients(ingredients) {
  let ingredient_table_body = document.querySelector('#ingredient_table_container tbody');

  ingredients.forEach(ingredient => {
    if(ingredient.ingredient_stock <= ingredient.ingredient_reminder) {
      ingredient_table_body.appendChild(createIngredientRow(ingredient));
    }
  })
}

function createIngredientRow(ingredient) {
  let tr = document.createElement('tr');
  
  let td1 = document.createElement('td');
  td1.textContent = ingredient.ingredient_name;
  tr.appendChild(td1);
  let td2 = document.createElement('td');
  td2.textContent = ingredient.ingredient_unit == "kg" ? ingredient.ingredient_stock + " kg" : ingredient.ingredient_stock + " pcs";
  tr.appendChild(td2);
  let td3 = document.createElement('td');
  td3.textContent = ingredient.ingredient_unit == "kg" ? ingredient.ingredient_reminder.toFixed(2) + " kg" : ingredient.ingredient_reminder.toFixed(2) + " pcs";
  tr.appendChild(td3);
  let td4 = document.createElement('td');
  td4.textContent = ingredient.ingredient_unit == "kg" ? ingredient.ingredient_usage_per_4_gallons + " kg" : ingredient.ingredient_usage_per_4_gallons + " pcs";
  tr.appendChild(td4);

  return tr;
}


//======================================================================================================================================




document.getElementById('time-toggles').addEventListener('click', (e) => {
  let target = e.target;
  
  Array.from(e.currentTarget.children).forEach(child => {
    child.classList.remove('selected');
  });

  target.classList.add('selected');
  
  if (target.id == "this_week") {
    displayThisWeek(transactions);
  } else if (target.id == "this_month") {
    displayThisMonth(transactions);
  } else {
    displayThisYear(transactions);
  }
})



//======================================================================================================================================

// QUICK CONTROLS
// QUICK CONTROLS
// QUICK CONTROLS


// ADD STOCK

let qc_add_stock_btn = document.getElementById('qc_add_stock_btn');

qc_add_stock_btn.addEventListener('click', (e) => {
  let add_stock_modal = document.getElementById('add_stock_modal');
  
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

  add_stock_modal.querySelector('#request_from').value = "/dashboard";

  showDialog(add_stock_modal);
});

document.getElementById('close_add_stock_modal').onclick = () => {
  closeDialog(add_stock_modal);
};

document.querySelector('.add-stock-form').onsubmit = (event) => {
  showMessageModal("Stock Sucessfully Added!");
}


// ADD ORDER
// ADD ORDER
// ADD ORDER
// ADD ORDER

let qc_add_order = document.getElementById('qc_add_order_btn');

qc_add_order.addEventListener('click', (e) => {  
  let add_order_modal =  document.getElementById('add_order_modal');

  let today = new Date(); 
  today.setDate(today.getDate() + 1);
  let tomorrow = today.toISOString().split('T')[0];
  add_order_modal.querySelector('#delivery_date').setAttribute('min', tomorrow);

  showDialog(add_order_modal);
})

qc_add_order.addEventListener('click', async () => {
  showDialog(add_order_modal);

  const flavorSelect = add_order_modal.querySelector('#flavor');
  while(flavorSelect.firstChild) {
    flavorSelect.removeChild(flavorSelect.firstChild);
  }

  Array.from(flavors).forEach(flavor => {
    const option = document.createElement('option');
    option.value = flavor.flavor_id;
    option.textContent = flavor.flavor_name;
    flavorSelect.appendChild(option);
  });

});

document.getElementById('add_order_form').addEventListener('submit', (e) => {
  
  e.preventDefault();

  let add_order_form = document.getElementById('add_order_form');

  let order = {
    flavor: Array.from(flavors).filter(flavor => {
      return flavor.flavor_id == add_order_form.querySelector('#flavor').value
    })[0],
    size: parseFloat(add_order_form.querySelector('#size').value) || null,
    delivery_address: add_order_form.querySelector('#delivery_adress').value || null,
    delivery_date: add_order_form.querySelector('#delivery_date').value || null,
    delivery_time: add_order_form.querySelector('#delivery_time').value || null,
    initial_payment: parseFloat(add_order_form.querySelector('#payment').value) || 0
  }  

  let price = add_order_form.querySelector('#size').value == 4 ? 1400 : 2700;
  if (order.initial_payment < 0 || order.initial_payment > price) {
    showMessageModal('Invalid payment. Please check your payment details and try again.');
    return;
  }

  let thereIsEmptyInfo = Object.values(order).some(value => value == null);
  if (thereIsEmptyInfo) {
    showMessageModal('Some required fields are missing or contain invalid data.');
    return;
  }

  document.querySelector('#add_order_modal #upcomming_order_container').appendChild(createOrderDiv(order));
})

document.getElementById('confirm_orders').addEventListener('click', async (e) => {
  let order_container = e.currentTarget.parentElement.previousElementSibling;
  
  if(order_container.children.length == 0) {
    showMessageModal('No orders found.');
    return;
  }
  
  let orders = [];
  let customer = {
    name: add_order_modal.querySelector('#name').value,
    contact: add_order_modal.querySelector('#contact_info').value,
    email: add_order_modal.querySelector('#email').value,
  }

  Array.from(order_container.children).forEach(order => {
    orders.push(Object(order.dataset));
  })

  let response = await fetch('apis/order/add-order.php', {
    method: 'POST',
    header: {
      'Content-type' : 'application/json'
    },
    body: JSON.stringify({
      customer: customer,
      orders: orders
    })
  })

  console.log(await response.json());

  while(order_container.firstChild) {
    order_container.removeChild(order_container.firstChild);
  }
})

function createOrderDiv(data) {
  let order = document.createElement('div');
  order.dataset.flavor = data.flavor.flavor_id;
  order.dataset.size = data.size;
  order.dataset.delivery_address = data.delivery_address;
  order.dataset.delivery_date = data.delivery_date;
  order.dataset.delivery_time = data.delivery_time;
  order.dataset.initial_payment = data.initial_payment;
  order.classList.add('order');

  let order_info = document.createElement('div');
  order_info.classList.add('order-info');
  order.appendChild(order_info);

  let flavor = document.createElement('p');
  flavor.textContent = "Flavor: " + data.flavor.flavor_name;
  order_info.appendChild(flavor);

  let size = document.createElement('p');
  size.textContent = "Size: " + data.size + " Gallons";
  order_info.appendChild(size);

  order_info.appendChild(document.createElement('br'));

  let address = document.createElement('p');
  address.textContent = "Address: \n" + data.delivery_address;
  order_info.appendChild(address);

  let date = document.createElement('p');
  date.textContent = "Date: \n" + data.delivery_date;
  order_info.appendChild(date);

  let time = document.createElement('p');
  time.textContent = "Time: \n" + data.delivery_time;
  order_info.appendChild(time);

  order_info.appendChild(document.createElement('br'));

  let initial_payment = document.createElement('p');
  initial_payment.textContent = "Initial Payment: ₱" + data.initial_payment;
  order_info.appendChild(initial_payment);

  let remove_order_btn = document.createElement('button');
  remove_order_btn.classList.add('remove-order-btn');
  remove_order_btn.textContent = "x";
  order.appendChild(remove_order_btn);

  remove_order_btn.addEventListener('click', () => {
    order.remove();
  });

  return order;
}

document.getElementById('close_add_order_modal').addEventListener('click', () => {
  closeDialog(add_order_modal);
});


//SHOW UPCOMMING ORDERS
//SHOW UPCOMMING ORDERS
//SHOW UPCOMMING ORDERS
//SHOW UPCOMMING ORDERS

let recent_orders_modal = document.getElementById('recent_orders_modal');
  
document.getElementById('qc_show_recent_orders').addEventListener('click', (e) => {

  let ongoingOrders = orders.filter(order => {
    return order.order_status == 'Upcomming';
  })

  while(recent_orders_modal.querySelector('table tbody').firstChild) {
    recent_orders_modal.querySelector('table tbody').removeChild(recent_orders_modal.querySelector('table tbody').firstChild);
  }

  Array.from(ongoingOrders).forEach(order => {
    recent_orders_modal.querySelector('table tbody').appendChild(createOrderRow(order));
  })
  
  showDialog(recent_orders_modal);
})

document.getElementById('close_recent_orders_modal').addEventListener('click', (e) => {
  closeDialog(recent_orders_modal)
})

function createOrderRow(order) {
  const tr = document.createElement('tr');
  const deliveryDateTime = new Date(order.order_delivery_datetime);
  const tdOperations = document.createElement('td');
  const divOperations = document.createElement('div');
  divOperations.classList.add('flex');
  divOperations.classList.add('gap-8');

  tdOperations.appendChild(divOperations);

  let processBtn = document.createElement('button');
  processBtn.dataset.order_id = order.order_id;
  processBtn.dataset.order_size = order.order_size;
  processBtn.classList.add('process-order-btn');
  processBtn.classList.add('btn');
  processBtn.classList.add('primary');
  processBtn.textContent = "Process";
  divOperations.appendChild(processBtn);

  let cancelBtn = document.createElement('button');
  cancelBtn.textContent = 'Cancel';
  cancelBtn.dataset.order_id = order.order_id;
  cancelBtn.dataset.order_size = order.order_size;
  cancelBtn.classList.add('cancel-order-btn');
  cancelBtn.classList.add('btn');
  cancelBtn.classList.add('danger');
  divOperations.appendChild(cancelBtn);

  attachEvent(processBtn, processOrder);
  attachEvent(cancelBtn, cancelOrder);

  function createCell(text) {
    const td = document.createElement('td');
    td.textContent = text;
    return td;
  }
  
  tr.appendChild(createCell(order.order_id));
  tr.appendChild(createCell(order.customer_name));
  tr.appendChild(createCell(order.customer_contact));
  tr.appendChild(createCell(order.order_size + " gallons"));
  tr.appendChild(createCell(order.flavor_name));
  tr.appendChild(createCell(order.order_delivery_address));
  tr.appendChild(createCell(deliveryDateTime.toISOString().split('T')[0]));
  tr.appendChild(createCell(deliveryDateTime.toTimeString().split(' ')[0]));
  tr.appendChild(createCell(`₱${order.order_price}`));
  tr.appendChild(createCell(`₱${order.order_payment}`));
  tr.appendChild(createCell(`₱${order.order_price - order.order_payment}`));
  tr.appendChild(tdOperations);

  return tr;
}

async function processOrder(event) {
  const target = event.target;

  let confirmed = await showConfirmationModal('Are you sure you want to process this order?');
  if (!confirmed) return;

  // CHECK IF THE INGREDIENTS IS SUFFICIENT
  if (! await stockIsSufficient(target.dataset.order_size)) {
    await showMessageModal('Not enough ingredients to process this order.');
    return;
  }

  document.querySelector('#recent_orders_modal .table-container tbody').removeChild(target.closest('tr'));
  const response = await fetch('apis/order/process-order.php', {
    method: "POST",
    headers: {
      'Content-Type': 'application/json'
    },
    body: JSON.stringify({
      order_id: target.dataset.order_id
    })
  });

  const result = await response.json();
  console.log(result);
}

async function cancelOrder(event) {
  const target = event.target;

  let confirmed = await showConfirmationModal('Are you sure you want to cancel this order?');
  if (!confirmed) return;

  document.querySelector('#recent_orders_modal .table-container tbody').removeChild(target.closest('tr'));
  const response = await fetch('apis/order/cancel-order.php', {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json'
    },
    body: JSON.stringify({
      order_id: target.dataset.order_id,
      size: target.dataset.order_size
    })
  });

  const result = await response.json();
  console.log(result);
}



// ADD FLAVOR MODAL
// ADD FLAVOR MODAL
// ADD FLAVOR MODAL

let add_flavor_modal = document.getElementById('add_flavor_modal');

document.getElementById('qc_add_flavor_btn').addEventListener('click', (e) => {
  add_flavor_modal.querySelector('#request_from').value = "/dashboard";
  showDialog(add_flavor_modal);
});

document.getElementById('close_add_flavor_modal').addEventListener('click', (e) => {
  closeDialog(add_flavor_modal);
})