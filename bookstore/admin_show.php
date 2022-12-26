<?php
session_start();
include("logout.php");
//---------------------------------------------------------------


?>
<html>

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <link rel="stylesheet" type="text/css" href="style.css">
  <title>書城管理系統</title>
</head>

<body>
<div class="admin_a">
        <div class="menu_title">~ 歡 迎 蒞 臨 網 路 書 城 ~</div>
        <nav class="menu">
            <a style="color:#ECF5FF;" href="admin_book_data.php" class="menu_item_in">📌 書單編輯</a>
            <a href='admin_order_data.php' class='menu_item'>訂單狀態</a>
            <a href='?logout=true' class='menu_item'>登出</a>
        </nav>
        <div class="admin_b">
      <canvas id="myChart"></canvas>
      <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    </div>
    <script>
      const ctx = document.getElementById('myChart');
      new Chart(ctx, {
        type: 'bar',
        data: {
          labels: ['一月', '二月', '三月', '四月', '五月', '六月', '七月', '八月', '九月', '十月', '十一月', '十二月'],
          datasets: [{
            label: '購買人數',
            data: [12, 19, 3, 51, 2, 3, 45, 66, 5, 10, 7, 36, 15],
            borderWidth: 1,
            backgroundColor: '#fff'
          }, {
            label: '購買人數2',
            data: [45, 12, 19, 3, 51, 3, 45, 66, 5, 10, 7, 36, 15],
            borderWidth: 1,
            backgroundColor: '#123'
          }]

        },
        options: {
          scales: {
            y: {
              beginAtZero: true
            }
          }
        }
      });
    </script>
</body>

</html>