

let category_btns = Array.from(document.querySelectorAll('.btn-container .category-btns-container button'));

category_btns.forEach((button) => {
  button.addEventListener('click', async (event) => {
    let target = event.target;

    changeCategoryBtn(target);
    clearOrderTbl();

    let orders = await getOrders(target);
    displayOrders(orders)
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

  let response = await fetch('phpAjax/changeCategory.php', {
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

function displayOrders(orders) {
  let orders_tbl = document.querySelector('.orders-tbl tbody');

  Array.from(orders).forEach(order => {
    let tr = document.createElement('tr');

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

    orders_tbl.appendChild(tr);
  });
}


let add_order_modal = document.getElementById('add_order_modal');

document.getElementById('show_add_order_modal').addEventListener('click', (event) => {
  showDialog(add_order_modal);
})

document.getElementById('close_add_order_modal').addEventListener('click', () => {
  closeDialog(add_order_modal);
})