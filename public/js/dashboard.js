
let sales;

document.addEventListener('DOMContentLoaded', async (event) => {
  sales = await getSales();
  console.log(sales);
});



async function getSales() {
  let response = await fetch('dashboardAjax/get-sales.php', {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json'
    }
  });

  let result = await response.json();
  return result;
}