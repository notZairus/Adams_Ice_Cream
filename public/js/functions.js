

function showDialog(modal) {
  modal.classList.add('open');
  modal.showModal();
  requestAnimationFrame(() => {
    modal.classList.add('showing');
  });
}

function closeDialog(modal) {
  modal.close();
  modal.classList.remove('showing');
  modal.classList.add('closing');

  modal.addEventListener('transitionend', () => {
    modal.classList.remove('open');
    modal.classList.remove('closing');
    modal.close();
  }, {once : true})

  Array.from(modal.querySelectorAll('input')).forEach(input => {
    input.value = "";
  })
}


function attachEvent(btn, callback) {
  btn.addEventListener('click', callback);
}

async function stockIsSufficient(size) {
  let response = await fetch('apis/inventory/check-stock.php', {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json'
    },
    body: JSON.stringify({
      size: size
    })
  })

  let result = await response.json();
  return result;
}