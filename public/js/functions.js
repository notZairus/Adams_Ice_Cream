

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