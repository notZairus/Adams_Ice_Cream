

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

async function showMessageModal(message, heading = 'Message') {

  const message_modal = document.getElementById('message_modal')
  message_modal.querySelector('.message').textContent = message;
  message_modal.querySelector('.heading').textContent = heading;

  showDialog(message_modal);

  let confirmed = await new Promise(resolve => {
    window.closeMessageModal = (confirmed) => {
      closeDialog(document.getElementById('message_modal'));
      resolve(confirmed);
    }
  })

  return confirmed;
}

async function showConfirmationModal(message, heading = 'Confirmation') {

  const confirmation_modal = document.getElementById('confirmation_modal');
  confirmation_modal.querySelector('.message').textContent = message;
  confirmation_modal.querySelector('.heading').textContent = heading;

  showDialog(confirmation_modal);

  let confirmed = await new Promise(resolve => {
    window.closeConfirmationModal = (confirmed) => {
      closeDialog(document.getElementById('confirmation_modal'));
      resolve(confirmed);
    }
  })

  return confirmed;
}