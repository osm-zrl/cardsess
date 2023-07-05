var ctx1 = document.getElementById('Chart1').getContext('2d');
let cardStat = [];
$.ajax({
  url: 'php/getCardsState.php',
  type: 'GET',
  dataType: 'json',
  success: function(data) {
    cardStat.push(data[1]['total_active_cards']);
    cardStat.push(data[2]['total_desactive_cards']);
    ChartColors();
  },
  error: function(jqXHR, textStatus, errorThrown) {
    console.log('Error: ' + textStatus);
  }
});

function ChartColors() {
  var myChart1 = new Chart(ctx1, {
    type: 'bar',
    data: {
      labels: ['active', 'inactive'],
      datasets: [{
        label: 'Entries',
        data: cardStat,
        backgroundColor: [
          '#1a7020', //#354EA1
          '#97111e' 
        ],
        borderColor: [
          '#1a7020',
          '#97111e' 
        ],
        borderWidth: 1
      }]
    }
  });
}

// presence rate chart //

function createLineChart(response) {
  var labels = [];
  var presentData = [];

  response.forEach(el => {
      labels.push(el.date_start); 
      presentData.push(el.present); 
  });

  var ctx = document.getElementById('chart').getContext('2d');
  var chart = new Chart(ctx, {
      type: 'line',
      data: {
          labels: labels,
          datasets: [{
              label: 'Present',
              data: presentData,
              backgroundColor: 'rgba(0, 123, 255, 0.2)', 
              borderColor: 'rgba(0, 123, 255, 1)', 
              borderWidth: 1
          }]
      },
      options: {
          responsive: true,
          scales: {
              x: {
                  display: true,
                  title: {
                      display: true,
                      text: 'Date'
                  }
              },
              y: {
                  display: true,
                  title:{
                      display: true,
                      text: 'Present'
                  },
                  suggestedMin: 0, 
                  suggestedMax: 40
              }
          }
      }
  });
}


var ctx3 = document.getElementById('Chart3').getContext('2d');
var myChart3 = new Chart(ctx3, {
  type: 'doughnut',
  data: {
    labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July'],
    datasets: [{
      label: 'Entries',
      data: [120, 200, 150, 300, 250, 180, 220],
      backgroundColor: [
        '#354EA1','#99A5CB','#414D75' 
      ],
      borderColor: [
        '#354EA1'
      ],
      borderWidth: 1
    }]
  },
  options: {
    scales: {
      yAxis: [{
        ticks: {
          beginAtZero: true,
          
        }
      }]
    }
  }
});
