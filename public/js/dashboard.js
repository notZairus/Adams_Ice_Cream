
let transactions;


document.addEventListener('DOMContentLoaded', async (event) => {
  transactions = await getAllTransactions();
  displayThisWeek(transactions);
});

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
  
    let mappedTransaction = {
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
        mappedTransaction.incomes.set(days[day], mappedTransaction.incomes.get(days[day]) + parseFloat(transaction.income_amount));
      } else {
        mappedTransaction.expenses.set(days[day], mappedTransaction.expenses.get(days[day]) + parseFloat(transaction.expense_amount));
      }
    });

    return mappedTransaction;
  }

  let mappedTransaction = mapTransaction(transactionThisWeek);

  const myChart = document.getElementById('myChart');
  new Chart(myChart, {
    type: 'line',
    data: {
      labels: Array.from(mappedTransaction.incomes.keys()),
      datasets: [
        {
          label: "Incomes",
          data: Array.from(mappedTransaction.incomes.values()),
          borderWidth: 1,
          borderColor: 'purple',
          backgroundColor: 'purple'
        },
        {
          label: "Expenses",
          data: Array.from(mappedTransaction.expenses.values()),
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

function displayThisMonth(transactions) {
  let transactionsArray = Array.from(transactions);

  function startOfMonth() {
    const date = new Date();
    date.setDate(1); // Set to first day of the month
    date.setHours(0, 0, 0, 0);
    return date;
  }

  let transactionThisMonth = transactionsArray.filter(transaction => {
    let transactionDate = new Date(transaction.transaction_datetime);
    return transactionDate >= startOfMonth() && transactionDate <= new Date();
  })

  
  console.log(transactionThisMonth);
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
  
  console.log(transactionThisYear);
}