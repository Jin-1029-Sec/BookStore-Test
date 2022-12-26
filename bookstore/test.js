var ctx = document.getElementById('myChart');
var myChart = new Chart(ctx, {
  type: 'bar',
  data: {
    labels: ['一月', '二月', '三月'],
    datasets: [{
      label: '銷售業績(百萬)',
      data: [60, 49, 72]
    }]
  }
});
