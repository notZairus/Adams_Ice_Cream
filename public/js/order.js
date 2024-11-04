  let orders;

  document.addEventListener('DOMContentLoaded', async () => {
    orders = await getAllOrders();
    displayOrdersByCategory(orders, "Upcomming");
  });

  async function getAllOrders() {
    let response = await fetch('apis/order/get-orders.php', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json'
      }
    });
    return response.json();
  }



  function displayOrdersByCategory(orders, category) {
    let orders_tbl = document.querySelector('.orders-tbl tbody');
    orders.forEach(order => {
      if (order.order_status == category) {
        orders_tbl.appendChild(createOrderRow(order, category));
      }
    });
  }

  function createOrderRow(order, category) {
    const tr = document.createElement('tr');
    const tdOperations = document.createElement('td');
    const divOperations = document.createElement('div');
    divOperations.classList.add('order-operations');

    if (category == 'Upcomming') {
      let processBtn = document.createElement('button');
      processBtn.dataset.order_id = order.order_id;
      processBtn.dataset.order_size = order.order_size;
      processBtn.classList.add('process-order-btn');
      processBtn.textContent = "Process";
      divOperations.appendChild(processBtn);
    
      let cancelBtn = document.createElement('button');
      cancelBtn.textContent = 'Cancel';
      cancelBtn.dataset.order_id = order.order_id;
      cancelBtn.dataset.order_size = order.order_size;
      cancelBtn.classList.add('cancel-order-btn');
      divOperations.appendChild(cancelBtn);

      attachEvent(processBtn, processOrder);
      attachEvent(cancelBtn, cancelOrder);
    } else if (category == 'Ongoing') {
      let paymentBtn = document.createElement('button');
      paymentBtn.classList.add('payment-order-btn');
      paymentBtn.textContent = "Update Payment";
      paymentBtn.dataset.order_id = order.order_id;
      divOperations.appendChild(paymentBtn);

      let finishedBtn = document.createElement('button');
      finishedBtn.classList.add('finish-order-btn');
      finishedBtn.textContent = "Finish";
      finishedBtn.dataset.order_id = order.order_id;
      divOperations.appendChild(finishedBtn);

      paymentBtn.addEventListener('click', (event) => {
        openUpdatePaymentModal(order.order_id, event.target);
      });

      attachEvent(finishedBtn, finishOrder);
    } else if (category == 'Cancelled') {
      let reactivateBtn = document.createElement('button');
      reactivateBtn.classList.add('reactivate-order-btn');
      reactivateBtn.textContent = "Reactivate";
      reactivateBtn.dataset.order_id = order.order_id;
      reactivateBtn.dataset.order_size = order.order_size;
      divOperations.appendChild(reactivateBtn);

      attachEvent(reactivateBtn, reactivateOrder);
    }

    tdOperations.appendChild(divOperations);
    tr.appendChild(tdOperations);

    const deliveryDateTime = new Date(order.order_delivery_datetime);

    function createCell(text) {
      const td = document.createElement('td');
      td.textContent = text;
      return td;
    }

    tr.appendChild(createCell(order.order_id));
    tr.appendChild(createCell(order.customer_name));
    tr.appendChild(createCell(order.customer_contact));
    tr.appendChild(createCell(order.order_size));
    tr.appendChild(createCell(order.flavor_name));
    tr.appendChild(createCell(order.order_delivery_address));
    tr.appendChild(createCell(deliveryDateTime.toISOString().split('T')[0]));
    tr.appendChild(createCell(deliveryDateTime.toTimeString().split(' ')[0]));
    tr.appendChild(createCell(`₱${order.order_payment}`));
    tr.appendChild(createCell(`₱${order.order_price - order.order_payment}`));
  
    return tr;
  }

  const category_btns = Array.from(document.querySelectorAll('.btn-container .category-btns-container button'));
  category_btns.forEach((button) => {
    button.addEventListener('click', async (event) => {
      const target = event.target;
      changeCategoryBtnStyle(target);
      clearOrderTbl();
      orders = await getAllOrders();
      displayOrdersByCategory(orders, target.textContent);
    });
  });

  function changeCategoryBtnStyle(target) {
    category_btns.forEach(btn => btn.classList.remove('selected'));
    target.classList.add('selected');
    document.querySelector('.category-h2').textContent = `${target.textContent} Orders`;
  }

  function clearOrderTbl() {
    const orders_tbl = document.querySelector('.orders-tbl tbody');
    while(orders_tbl.firstChild) {
      orders_tbl.removeChild(orders_tbl.firstChild);
    }
  }







  //===================================================================================================================================

    // ORDER OPERATIONS
    // ORDER OPERATIONS
    // ORDER OPERATIONS
  
  async function processOrder(event) {
    const target = event.target;

    // CHECK IF THE INGREDIENTS IS SUFFICIENT
    if (! await stockIsSufficient(target.dataset.order_size)) {
      alert('Insufficient ingredients');
      return;
    }

    document.querySelector('.orders-tbl tbody').removeChild(target.closest('tr'));
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

    document.querySelector('.orders-tbl tbody').removeChild(target.closest('tr'));
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

  async function reactivateOrder(event) {
    const target = event.target;
    
    document.querySelector('.orders-tbl tbody').removeChild(target.closest('tr'));
    const response = await fetch('apis/order/reactivate-order.php', {
      method: 'POST',
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

  async function finishOrder(event) {
    const target = event.target;

    let balance = target.closest('tr').querySelector('td:nth-child(11)').textContent;
    balance = parseFloat(balance.replace('₱', ''));

    if (balance != 0) {
      alert(`Order #${target.dataset.order_id} requires full payment of ₱${balance} before completion.`)
      return;
    }

    document.querySelector('.orders-tbl tbody').removeChild(target.closest('tr'));
    const response = await fetch('apis/order/finish-order.php', {
      method: 'POST',
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

  //===================================================================================================================================

    // MODALS
    // MODALS
    // MODALS

  const add_order_modal = document.getElementById('add_order_modal');

  document.getElementById('show_add_order_modal').addEventListener('click', async () => {
    showDialog(add_order_modal);
    const flavors = await (async () => {
      const res = await fetch('apis/order/get-flavors.php', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json'
        }
      });
      return res.json();
    })();

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
    
  document.getElementById('close_add_order_modal').addEventListener('click', () => {
    closeDialog(add_order_modal);
  });



  const update_payment_modal = document.getElementById('update_payment_modal');

  function openUpdatePaymentModal(order_id, target) {

    let balance = target.closest('tr').querySelector('td:nth-child(11)').textContent;
    balance = parseFloat(balance.replace('₱', ''));

    if (balance  <= 0) {
      alert(`Order #${order_id} is fully paid. No additional payment needed.`);
      return;
    }

    showDialog(update_payment_modal);

    const update_payment_form = update_payment_modal.querySelector('form');
    update_payment_form.querySelector('input[name="order_id"]').value = order_id;
    update_payment_form.querySelector('input[name="amount"]').max = balance;
  }

  document.getElementById('close_update_payment_modal').addEventListener('click', () => {
    closeDialog(update_payment_modal);
  });

  //===================================================================================================================================