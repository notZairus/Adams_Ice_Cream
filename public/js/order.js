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
    } else if (category == 'Ongoing') {
      let paymentBtn = document.createElement('button');
      paymentBtn.classList.add('payment-order-btn');
      paymentBtn.classList.add('btn');
      paymentBtn.classList.add('primary');
      paymentBtn.textContent = "Payment";
      paymentBtn.dataset.order_id = order.order_id;
      divOperations.appendChild(paymentBtn);

      let finishedBtn = document.createElement('button');
      finishedBtn.classList.add('finish-order-btn');
      finishedBtn.classList.add('btn');
      finishedBtn.classList.add('primary');
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
      reactivateBtn.classList.add('btn');
      reactivateBtn.classList.add('primary');
      reactivateBtn.textContent = "Reactivate";
      reactivateBtn.dataset.order_id = order.order_id;
      reactivateBtn.dataset.order_size = order.order_size;
      divOperations.appendChild(reactivateBtn);

      attachEvent(reactivateBtn, reactivateOrder);
    }

    tdOperations.appendChild(divOperations);

    const deliveryDateTime = new Date(order.order_delivery_datetime);

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

  const category_btns = Array.from(document.querySelectorAll('.btn-container .category-btns-container button'));
  category_btns.forEach((button) => {
    button.addEventListener('click', async (event) => {
      const target = event.target;
      changeCategoryBtnStyle(target);
      clearOrderTbl();
      orders = await getAllOrders();
      clearOrderTbl();
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

    let confirmed = await showConfirmationModal('Are you sure you want to process this order?');
    if (!confirmed) return;

    // CHECK IF THE INGREDIENTS IS SUFFICIENT
    if (! await stockIsSufficient(target.dataset.order_size)) {
      await showMessageModal('Not enough ingredients to process this order.');
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

    let confirmed = await showConfirmationModal('Are you sure you want to cancel this order?');
    if (!confirmed) return;

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

    let confirmed = await showConfirmationModal('Are you sure you want to reactivate this order?');
    if (!confirmed) return;
    
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
    
    let confirmed = await showConfirmationModal('Are you sure you want to finish this order?');
    if (!confirmed) return;

    let balance = target.closest('tr').querySelector('td:nth-child(11)').textContent;
    balance = parseFloat(balance.replace('₱', ''));

    if (balance != 0) {
      showMessageModal(`Order #${target.dataset.order_id} requires full payment of ₱${balance} before completion.`);
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
  let flavors = null;

  document.getElementById('show_add_order_modal').addEventListener('click', async () => {

    let today = new Date(); 
    today.setDate(today.getDate() + 1);
    let tomorrow = today.toISOString().split('T')[0];
    add_order_modal.querySelector('#delivery_date').setAttribute('min', tomorrow);

    showDialog(add_order_modal);
    
    flavors = await (async () => {
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
    
    if(e.currentTarget.parentElement.previousElementSibling.children.length == 0) {
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

    location.reload();
    console.log(await response.json());
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

















  const update_payment_modal = document.getElementById('update_payment_modal');

  function openUpdatePaymentModal(order_id, target) {

    let balance = target.closest('tr').querySelector('td:nth-child(11)').textContent;
    balance = parseFloat(balance.replace('₱', ''));

    if (balance  <= 0) {
      showMessageModal(`Order #${order_id} is fully paid. No additional payment needed.`);
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