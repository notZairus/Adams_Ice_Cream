
let transactions;
let flavors;
let ingredients;

let currentChart1 = null;


document.addEventListener('DOMContentLoaded', async (event) => {
  transactions = await getAllTransactions();
  flavors = await getAllFlavors();
  ingredients = await getAllIngredients();

  displayThisWeek(transactions);
  displayTopSellingFlavors(flavors);
  displayLowStockIngredients(ingredients);
});

//======================================================================================================================================

// TRANSACTION STATS
// TRANSACTION STATS
// TRANSACTION STATS

async function getAllTransactions() {
  let response = await fetch('apis/dashboard/get-all-transactions.php', {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json'
    }
  });

  let result = await response.json();
  return result;
}

function displayThisWeek(transactions) {
  let transactionsArray = Array.from(transactions);

  function startOfWeek() {
    const now = new Date();
    const dayOfWeek = now.getDay(); // 0 is Sunday, 6 is Saturday
    const date = new Date(now);
    date.setDate(now.getDate() - dayOfWeek); // Move to start of the week (Sunday)
    date.setHours(0, 0, 0, 0);
    return date;
  }

  let transactionThisWeek = transactionsArray.filter(transaction => {
    let transactionDate = new Date(transaction.transaction_datetime);
    return transactionDate >= startOfWeek() && transactionDate <= new Date();
  })

  function mapTransaction(transactionThisWeek) {
    let days = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
  
    let mappedTransactions = {
      expenses: new Map([
        ['Sunday', 0],
        ['Monday', 0],
        ['Tuesday', 0],
        ['Wednesday', 0],
        ['Thursday', 0],
        ['Friday', 0],
        ['Saturday', 0]
      ]),
      incomes: new Map([
        ['Sunday', 0],
        ['Monday', 0],
        ['Tuesday', 0],
        ['Wednesday', 0],
        ['Thursday', 0],
        ['Friday', 0],
        ['Saturday', 0]
      ])
    }

    transactionThisWeek.forEach(transaction => {
      let date = new Date(transaction.transaction_datetime);
      let day = date.getDay();

      if (transaction.transaction_type == "INCOME") {
        mappedTransactions.incomes.set(days[day], mappedTransactions.incomes.get(days[day]) + parseFloat(transaction.income_amount));
      } else {
        mappedTransactions.expenses.set(days[day], mappedTransactions.expenses.get(days[day]) + parseFloat(transaction.expense_amount));
      }
    });

    return mappedTransactions;
  }

  let mappedTransactions = mapTransaction(transactionThisWeek);

  displayChart(mappedTransactions);

  
}

function displayThisMonth(transactions) {
  let transactionsArray = Array.from(transactions);

  //helper function to get the start of the month
  function startOfMonth() {
    const date = new Date();
    date.setDate(1); // Set to first day of the month
    date.setHours(0, 0, 0, 0);
    return date;
  }

  //filter transactions that are in this month
  let transactionThisMonth = transactionsArray.filter(transaction => {
    let transactionDate = new Date(transaction.transaction_datetime);
    return transactionDate >= startOfMonth() && transactionDate <= new Date();
  })

  //assign transactions on each day that has it
  function mapTransaction(transactionThisMonth) {
    let now = new Date();
    let daysInMonth = new Date(now.getFullYear(), now.getMonth() + 1, 0).getDate();
    
    let mappedTransactions = {
      expenses: new Map([
      ]),
      incomes: new Map([
      ])
    };

    for (let i = 0; i < daysInMonth; i++) {
      mappedTransactions.expenses.set(i + 1, 0);
      mappedTransactions.incomes.set(i + 1, 0);
    }

    transactionThisMonth.forEach(transaction => {
      let date = new Date(transaction.transaction_datetime);
      let day = date.getDate();

      if (transaction.transaction_type == "INCOME") {
        mappedTransactions.incomes.set(day, mappedTransactions.incomes.get(day) + parseFloat(transaction.income_amount));
      } else {
        mappedTransactions.expenses.set(day, mappedTransactions.expenses.get(day) + parseFloat(transaction.expense_amount));
      }
    });

    return mappedTransactions;

  }

  let mappedTransactions = mapTransaction(transactionThisMonth);

  let days = Array.from(mappedTransactions.expenses.keys()).map(day => {
    let months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
    let now = new Date();
    return `${months[now.getMonth()]}${day}`;
  })

  displayChart(mappedTransactions);
}

function displayThisYear(transactions) {
  let transactionsArray = Array.from(transactions);

  function startOfYear() {
    const date = new Date();
    date.setMonth(0, 1); // January 1st
    date.setHours(0, 0, 0, 0);
    return date;
  }

  let transactionThisYear = transactionsArray.filter(transaction => {
    let transactionDate = new Date(transaction.transaction_datetime);
    return transactionDate >= startOfYear() && transactionDate <= new Date();
  })
  
  function mapTransaction(transactionThisYear) {
    let now = new Date();
    let months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
    let mappedTransactions = {
      expenses: new Map([
      ]),
      incomes: new Map([
      ])
    };

    months.forEach(month => {
      mappedTransactions.expenses.set(month, 0);
      mappedTransactions.incomes.set(month, 0);
    });

    transactionThisYear.forEach(transaction => {
      let date = new Date(transaction.transaction_datetime);
      let monthIndex = date.getMonth();

      if (transaction.transaction_type == "INCOME") {
        mappedTransactions.incomes.set(months[monthIndex], mappedTransactions.incomes.get(months[monthIndex]) + parseFloat(transaction.income_amount));
      } else {
        mappedTransactions.expenses.set(months[monthIndex], mappedTransactions.expenses.get(months[monthIndex]) + parseFloat(transaction.expense_amount));
      }
      
    });

    return mappedTransactions;
  };

  let mappedTransactions = mapTransaction(transactionThisYear);

  displayChart(mappedTransactions);
}

function displayChart(transactions) {
  
  if (currentChart1) currentChart1.destroy();

  let mappedTransactions = transactions;

  const myChart = document.getElementById('myChart');
  currentChart1 = new Chart(myChart, {
    type: 'bar',
    data: {
      labels: Array.from(mappedTransactions.incomes.keys()),
      datasets: [
        {
          label: "Incomes",
          data: Array.from(mappedTransactions.incomes.values()),
          borderWidth: 1,
          borderColor: '#334259',
          backgroundColor: '#334259'
        },
        {
          label: "Expenses",
          data: Array.from(mappedTransactions.expenses.values()),
          borderWidth: 1,
          borderColor: 'red',
          backgroundColor: 'red'
        },
      ]
    },
    options: {
      scales: {
        y: {
          beginAtZero: true
        }
      }
    }
  });

}

//======================================================================================================================================


//======================================================================================================================================

// FLAVORS
// FLAVORS
// FLAVORS
  
async function getAllFlavors() {
  let response = await fetch('apis/dashboard/get-all-flavors.php', {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json'
    }
  });

  let result = await response.json();
  return Array.from(result).sort((a, b) => b.flavor_order_count - a.flavor_order_count);
}

function displayTopSellingFlavors(flavors) {
  let flavor_container = document.getElementById('flavor_container');

  flavors.forEach(flavor => {
    let a = document.createElement('a');
    a.classList.add('flavor');
    //a.href = `https://en.wikipedia.org/wiki/${flavor.flavor_name}`;
    a.href = "https://fb.com";
    a.target = "_blank";
    a.textContent = flavor.flavor_name;

    flavor_container.appendChild(a);
  });
}

//======================================================================================================================================


//======================================================================================================================================

// INGREDIENTS
// INGREDIENTS
// INGREDIENTS
  
async function getAllIngredients() {
  let response = await fetch('apis/dashboard/get-all-ingredients.php', {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json'
    }
  });

  let result = await response.json();
  return result;
}

function displayLowStockIngredients(ingredients) {
  let ingredient_table_body = document.querySelector('#ingredient_table_container tbody');

  ingredients.forEach(ingredient => {
    if(ingredient.ingredient_stock <= ingredient.ingredient_reminder) {
      ingredient_table_body.appendChild(createIngredientRow(ingredient));
    }
  })
}

function createIngredientRow(ingredient) {
  let tr = document.createElement('tr');
  
  let td1 = document.createElement('td');
  td1.textContent = ingredient.ingredient_name;
  tr.appendChild(td1);
  let td2 = document.createElement('td');
  td2.textContent = ingredient.ingredient_stock;
  tr.appendChild(td2);
  let td3 = document.createElement('td');
  td3.textContent = ingredient.ingredient_reminder;
  tr.appendChild(td3);
  let td4 = document.createElement('td');
  td4.textContent = ingredient.ingredient_usage_per_4_gallons;
  tr.appendChild(td4);

  return tr;
}


//======================================================================================================================================




document.getElementById('time-toggles').addEventListener('click', (e) => {
  let target = e.target;
  
  Array.from(e.currentTarget.children).forEach(child => {
    child.classList.remove('selected');
  });

  target.classList.add('selected');
  
  if (target.id == "this_week") {
    displayThisWeek(transactions);
  } else if (target.id == "this_month") {
    displayThisMonth(transactions);
  } else {
    displayThisYear(transactions);
  }
})