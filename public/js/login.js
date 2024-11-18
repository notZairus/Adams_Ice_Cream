
document.querySelector('.forgot-password-a').addEventListener('click', async (e) => {
  await showMessageModal('a reset email has been sent to the owner\'s email address.');

  let response = await fetch('apis/login/forgot-password.php');
  let result = await response.json();
  console.log(result);
})