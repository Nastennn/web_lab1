"use strict";

function buildTable() {
    const rows = JSON.parse(localStorage.getItem("table"));

    let html = `
    <table align="center"><thead><tr>
        <th><h5>Х</h5></th>
        <th><h5>Y</h5></th>
        <th><h5>R</h5></th>
        <th><h5>Результат</h5></th>
        <th><h5>Время</h5></th>
        </tr></thead>
    `;

    for (const row of rows) {
        html += `<tr><td>${row.x}</td><td>${row.y}</td><td>${row.r}</td><td>${row.result}</td><td>${row.time}</td></tr>`;
    }

    document.getElementById("request").innerHTML = html;

}

function start() {
    let xhr = new XMLHttpRequest();
    xhr.open("POST", '/index.php', true);
    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhr.onreadystatechange = function() {
        if(xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) {
            document.getElementById("request").innerHTML = xhr.responseText;
        }
    };
    xhr.send("foo=bar&lorem=ipsum");
}