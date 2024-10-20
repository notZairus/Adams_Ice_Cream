

let category_btns = Array.from(document.querySelectorAll('.btn-container .category-btns-container button'));

category_btns.forEach((button) => {
  button.addEventListener('click', async (event) => {
    let target = event.target;

    changeCategoryBtn(target);
    clearOrderTbl();

    let orders = await getOrders(target);
    displayOrders(orders, target);
  })
})


function changeCategoryBtn(target) {
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

async function getOrders(target) {
  let data = {
    category: target.textContent
  };

  let response = await fetch('orderAjax/changeCategory.php', {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json'
    },
    body: JSON.stringify(data)
  }); 

  if (! response.ok) {
    alert('Response is not okay!');
  }

  return await response.json();
}

function displayOrders(orders, target) {
  let orders_tbl = document.querySelector('.orders-tbl tbody');

  Array.from(orders).forEach(order => {
    let tr = document.createElement('tr');

    let td9 = document.createElement('td');
    tr.appendChild(td9);

    let td1 = document.createElement('td');
    td1.textContent = order.order_id;
    tr.appendChild(td1);
    
    let td2 = document.createElement('td');
    td2.textContent = order.customer_name;
    tr.appendChild(td2);

    let td3 = document.createElement('td');
    td3.textContent = order.customer_contact;
    tr.appendChild(td3);

    let td4 = document.createElement('td');
    td4.textContent = order.order_size;
    tr.appendChild(td4);

    let td5 = document.createElement('td');
    td5.textContent = order.order_flavor;
    tr.appendChild(td5);

    let td6 = document.createElement('td');
    td6.textContent = order.order_delivery_address;
    tr.appendChild(td6);

    let [date, time] = order.order_delivery_datetime.split(" ");

    let td7 = document.createElement('td');
    td7.textContent = date;
    tr.appendChild(td7);

    let td8 = document.createElement('td');
    td8.textContent = time;
    tr.appendChild(td8);

    let operations = document.createElement('div');
    operations.classList.add('order-operations');
    td9.appendChild(operations);

    if (target.textContent == 'Upcomming') {
      let processBtn = document.createElement('button');
      processBtn.dataset.order_id = order.order_id;
      processBtn.classList.add('process-order-btn');
      processBtn.textContent = "Process";
      operations.appendChild(processBtn);

      attachEvent(processBtn, processOrder);
      
      let cancelBtn = document.createElement('button');
      cancelBtn.textContent = 'Cancel';
      cancelBtn.dataset.order_id = order.order_id;
      cancelBtn.classList.add('cancel-order-btn');
      operations.appendChild(cancelBtn);


    } else if (target.textContent == 'Ongoing') {
      let finishedBtn = document.createElement('button');
      finishedBtn.classList.add('finish-order-btn');
      finishedBtn.textContent = "Finish";
      finishedBtn.dataset.order_id = order.order_id;
      operations.appendChild(finishedBtn);

      attachEvent(finishedBtn, finishOrder);
    }

    let tdstatus = document.createElement('td');
    tdstatus.textContent = order.order_status;
    tr.appendChild(tdstatus);

    orders_tbl.appendChild(tr);
  });
}


let processBtns = document.querySelectorAll('.process-order-btn');


//PROCESS ORDER
Array.from(processBtns).forEach(btn => {
  btn.addEventListener('click', processOrder);
});

async function processOrder(event) {
  let target = event.target;

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
}

async function finishOrder(event) {s
  let target = event.target;

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
}











let add_order_modal = document.getElementById('add_order_modal');

document.getElementById('show_add_order_modal').addEventListener('click', (event) => {
  showDialog(add_order_modal);
})

document.getElementById('close_add_order_modal').addEventListener('click', () => {
  closeDialog(add_order_modal);
})