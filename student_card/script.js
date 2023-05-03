var ctx1 = document.getElementById('Chart1').getContext('2d');
var myChart1 = new Chart(ctx1, {
  type: 'bar',
  data: {
    labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July'],
    datasets: [{
      label: 'Sales',
      data: [120, 200, 150, 300, 250, 180, 220],
      backgroundColor: [
        '#354EA1'
      ],
      borderColor: [
        '#354EA1'
      ],
      borderWidth: 1
    }]
  },
  options: {
    scales: {
      yAxes: [{
        ticks: {
          beginAtZero: true
        }
      }]
    }
  }
});


var ctx2 = document.getElementById('Chart2').getContext('2d');
var myChart2 = new Chart(ctx2, {
  type: 'line',
  data: {
    labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July'],
    datasets: [{
      label: 'Sales',
      data: [120, 200, 150, 300, 250, 180, 220],
      backgroundColor: [
        '#354EA1'
      ],
      borderColor: [
        '#354EA1'
      ],
      borderWidth: 1
    }]
  },
  options: {
    scales: {
      yAxes: [{
        ticks: {
          beginAtZero: true
        }
      }]
    }
  }
});

var ctx3 = document.getElementById('Chart3').getContext('2d');
var myChart3 = new Chart(ctx3, {
  type: 'doughnut',
  data: {
    labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July'],
    datasets: [{
      label: 'Sales',
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
      yAxes: [{
        ticks: {
          beginAtZero: true
        }
      }]
    }
  }
});

function toggleAddStudent() {
  let addStudent = document.getElementById('addstudent');
  if (addStudent.classList.contains('hidden')) {
  addStudent.classList.remove('hidden');
  } else {
  addStudent.classList.add('hidden');
  }
  }


function confirmdelete(params) {
  return confirm('Are you sure you want to delete this student?')
}


function toggleEditStudent() {
  let editStudent = document.getElementById('editstudent');
  if (editStudent.classList.contains('hidden')) {
    editStudent.classList.remove('hidden');
  } else {
    editStudent.classList.add('hidden');
  }
  }




  