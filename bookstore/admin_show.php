<html>

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<link rel="stylesheet" type="text/css" href="style.css">
	<title>書城管理系統</title>
</head>

<body>
<div>
  <canvas id="myChart"></canvas>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>



<script>
  const ctx = document.getElementById('myChart');
  new Chart(ctx, {
    type: 'bar',
    data: {
      labels: ['一月', '二月', '三月', '四月', '五月', '六月','七月','八月','九月','十月','十一月','十二月'],
      datasets: [{
        label: '購買人數',
        data: [12, 19, 3, 51, 2, 3,45,66,5,10,7,36,15],
        borderWidth: 1,
		backgroundColor:'#fff'
      },{
		label: '購買人數2',
        data: [45,12, 19, 3, 51, 3,45,66,5,10,7,36,15],
        borderWidth: 1,
		backgroundColor:'#123'
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