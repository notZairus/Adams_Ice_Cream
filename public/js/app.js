
let mobile_navigation = document.getElementById('mobile_navigation');
document.getElementById('hamburger_menu').addEventListener('click', (e) => {
  if (mobile_navigation.classList.contains('open')) {
    mobile_navigation.classList.remove('open');
    requestAnimationFrame(() => {
      mobile_navigation.classList.remove('show');
      mobile_navigation.classList.add('hide');
    })
  } else {
    mobile_navigation.classList.add('open');
    requestAnimationFrame(() => {
      mobile_navigation.classList.remove('hide');
      mobile_navigation.classList.add('show');
    })
  }
});