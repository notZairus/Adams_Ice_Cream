
let sales;

document.addEventListener('DOMContentLoaded', async (event) => {
  sales = await getSales();
  console.log(sales);
});


async function getSales() {
  let response = await fetch('apis/dashboard/get-sales.php', {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json'
    }
  });

  let result = await response.json();
  return result;
}


function displayChart() {
  const myChart = document.getElementById('myChart');
  const ctx = myChart.getContext('2d');
}