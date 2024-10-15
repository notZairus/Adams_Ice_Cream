

let category_btns = Array.from(document.querySelectorAll('.btn-container .category-btns-container button'));

category_btns.forEach((button) => {
  button.addEventListener('click', (event) => {
    changeCategory(event);
  })
})

function changeCategory(event) {
  category_btns.forEach(btn => {
    btn.classList.remove('selected');
  })

  let target = event.target;
  target.classList.add('selected');

  document.querySelector('.category-h2').textContent = `${target.textContent} Orders`;
}

