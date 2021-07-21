window.onload = () => {
  const btnGetAccount = document.getElementById('btnGet');
  const btnShow = document.getElementById('btnShow');

  btnGetAccount.addEventListener('click', getAccount);
  btnShow.addEventListener('click', getData);
}

function getAccount(e) {
  e.preventDefault();
  const accountInput = document.getElementById('accountInput');
  const xhr = new XMLHttpRequest();

  xhr.open('POST', `/api/get-account/?account=${accountInput.value}`, true);
  xhr.onload = function () {
    const result = JSON.parse(this.responseText);
    const table = document.getElementById('table');

    if (this.status == 200) {
      table.innerHTML = `
            <tr>
              <th>Account Name</th>
              <th>Account ID</th>
              <th>Spend</th>
              <th>Clicks</th>
              <th>Impressions</th>
              <th>Cost per Click</th>
            </tr>
          `
        result.map(r => {
          table.innerHTML = `
                ${table.innerHTML}
                <tr ${r.status == "INACTIVE" ? "class='inactive'" : ""}>
                  <td >${r.accountName}</td>
                  <td >${r.accountId}</td>
                  <td >${parseFloat(r.Metrics.spend.$numberDecimal ? r.Metrics.spend.$numberDecimal : r.Metrics.spend)}</td>
                  <td >${parseFloat(r.Metrics.clicks)}</td>
                  <td >${parseFloat(r.Metrics.impressions)}</td>
                  <td >${parseFloat(r.Metrics.costPerClick.$numberDecimal ? r.Metrics.costPerClick.$numberDecimal : r.Metrics.costPerClick)}</td>
                </tr>
              `
        })
    } else if (this.status == 404) {
      table.innerHTML = `
            <tr>
              <th>Account Name</th>
              <th>Account ID</th>
              <th>Spend</th>
              <th>Clicks</th>
              <th>Impressions</th>
              <th>Cost per Click</th>
            </tr>
          `
      table.innerHTML += `
          <tr class="no_account_data">
            <td>No data available for the supplied Account Id</td>
          </tr>
          `
    }
  }

  xhr.send();
}

function getData(e) {
  e.preventDefault();
  const filter = document.getElementById('filter');
  const xhr = new XMLHttpRequest();
  let requestData = new FormData();

  xhr.open('GET', `./api/show/?filter=${filter.value}`, true);
  xhr.onload = function () {
    if (this.status == 200) {
      const result = JSON.parse(this.responseText);

      const table = document.getElementById('table');

      table.innerHTML = `
          <tr>
            <th>Account Name</th>
            <th>Account ID</th>
            <th>Spend</th>
            <th>Clicks</th>
            <th>Impressions</th>
            <th>Cost per Click</th>
          </tr>
        `

      result.map(r => {
        table.innerHTML = `
            ${table.innerHTML}
            <tr ${r.status == "INACTIVE" ? "class='inactive'" : ""}>
              <td >${r.accountName}</td>
              <td >${r.accountId}</td>
              <td >${parseFloat(r.Metrics.spend.$numberDecimal ? r.Metrics.spend.$numberDecimal : r.Metrics.spend)}</td>
              <td >${parseFloat(r.Metrics.clicks)}</td>
              <td >${parseFloat(r.Metrics.impressions)}</td>
              <td >${parseFloat(r.Metrics.costPerClick.$numberDecimal ? r.Metrics.costPerClick.$numberDecimal : r.Metrics.costPerClick)}</td>
            </tr>
          `
      })
    }
  }

  xhr.send();
}
