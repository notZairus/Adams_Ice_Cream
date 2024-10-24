
let orders;

document.addEventListener('DOMContentLoaded', async () => {
  orders = await getAllOrders();
  displayOrdersByCategory(orders, "Upcomming");
})

async function getAllOrders() {
  let response = await fetch('orderAjax/get-orders.php', {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json'
    }
  })

  let result = response.json();

  return result;
}

function displayOrdersByCategory(orders, category) {
  let orders_tbl = document.querySelector('.orders-tbl tbody');
  orders.forEach(order => {
    if (order.order_status == category) {
      orders_tbl.appendChild(createOrderRow(order, category))
    }
  }) 
}

function createOrderRow(order, category) {
  const tr = document.createElement('tr'); // Create the table row

  // Create the first cell with buttons
  const tdOperations = document.createElement('td');
  const divOperations = document.createElement('div');
  divOperations.classList.add('order-operations');


  if (category == 'Upcomming') {
    let processBtn = document.createElement('button');
    processBtn.dataset.order_id = order.order_id;
    processBtn.classList.add('process-order-btn');
    processBtn.textContent = "Process";
    divOperations.appendChild(processBtn);

    attachEvent(processBtn, processOrder);
    
    let cancelBtn = document.createElement('button');
    cancelBtn.textContent = 'Cancel';
    cancelBtn.dataset.order_id = order.order_id;
    cancelBtn.classList.add('cancel-order-btn');
    divOperations.appendChild(cancelBtn);

  } else if (category == 'Ongoing') {
    let finishedBtn = document.createElement('button');
    finishedBtn.classList.add('finish-order-btn');
    finishedBtn.textContent = "Finish";
    finishedBtn.dataset.order_id = order.order_id;
    divOperations.appendChild(finishedBtn);

    attachEvent(finishedBtn, finishOrder);
  }

  tdOperations.appendChild(divOperations);
  tr.appendChild(tdOperations);

  // Create the delivery DateTime
  const deliveryDateTime = new Date(order.order_delivery_datetime);

  // Helper function to create a table cell with text content
  function createCell(text) {
      const td = document.createElement('td');
      td.textContent = text;
      return td;
  }

  // Append the other table cells
  tr.appendChild(createCell(order.order_id));
  tr.appendChild(createCell(order.customer_name));
  tr.appendChild(createCell(order.customer_contact));
  tr.appendChild(createCell(order.order_size));
  tr.appendChild(createCell(order.flavor_name));
  tr.appendChild(createCell(order.order_delivery_address));
  tr.appendChild(createCell(deliveryDateTime.toISOString().split('T')[0])); // Delivery date (Y-m-d)
  tr.appendChild(createCell(deliveryDateTime.toTimeString().split(' ')[0])); // Delivery time (H:i:s)
  tr.appendChild(createCell(`₱${order.order_payment}/₱${order.order_price}`));
  
  return tr; // Return the constructed row
}



let category_btns = Array.from(document.querySelectorAll('.btn-container .category-btns-container button'));

category_btns.forEach((button) => {
  button.addEventListener('click', (event) => {
    let target = event.target;

    changeCategoryBtnStyle(target);
    
    clearOrderTbl();
    displayOrdersByCategory(orders, target.textContent);
  })
})

function changeCategoryBtnStyle(target) {
  category_btns.forEach(btn => {
    btn.classList.remove('selected');
  })
  
  target.classList.add('selected');
  document.querySelector('.category-h2').textContent = `${target.textContent} Orders`;
}

function clearOrderTbl() {
  let orders_tbl = document.querySelector('.orders-tbl tbody');

  while(orders_tbl.firstChild) {
    orders_tbl.removeChild(orders_tbl.firstChild);
  }
}



//PROCESS ORDER
async function processOrder(event) {
  let target = event.target;
  let currentCategory = document.querySelector('.category-btns-container .selected').textContent;

  document.querySelector('.orders-tbl tbody').removeChild(target.closest('tr'));

  let response = await fetch('orderAjax/process-order.php', {
    method: "POST",
    headers: {
      'Content-Type': 'application/json'
    },
    body: JSON.stringify({
      order_id: target.dataset.order_id
    })
  })

  orders = await getAllOrders();
}

//FINISH ORDER
async function finishOrder(event) {
  let target = event.target;
  let currentCategory = document.querySelector('.category-btns-container .selected').textContent;

  document.querySelector('.orders-tbl tbody').removeChild(target.closest('tr'));

  let response = await fetch('orderAjax/finish-order.php', {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json'
    },
    body: JSON.stringify({
      order_id: target.dataset.order_id
    })
  });

  orders = await getAllOrders();
}











let add_order_modal = document.getElementById('add_order_modal');

document.getElementById('show_add_order_modal').addEventListener('click', async (event) => {
  showDialog(add_order_modal);

  let flavors = await (async function () {
    let res = await fetch('orderAjax/get-flavors.php', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json'
      }
    })
  
    let rs = await res.json();
    return rs;
  })();

  let flavorSelect = add_order_modal.querySelector('#flavor');

  while(flavorSelect.firstChild) {
    flavorSelect.removeChild(flavorSelect.firstChild);
  }

  Array.from(flavors).forEach(flavor => {
    let option = document.createElement('option');
    option.value = flavor.flavor_id;
    option.textContent = flavor.flavor_name;

    flavorSelect.appendChild(option);
  })
})

document.getElementById('close_add_order_modal').addEventListener('click', () => {
  closeDialog(add_order_modal);
});