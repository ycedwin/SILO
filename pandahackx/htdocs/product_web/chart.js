

function drawChart(data, date, ip, age, job) {

new Chart(document.getElementById("pie-chart"), {
    type: 'pie',
    data: {
      labels: ["male", "female"],
      datasets: [{
        label: "person",
        backgroundColor: ["#015475", "#1a7501"],
        data: data
      }]
    },
    options: {
      title: {
        display: false,
        text: 'Gender composition of the users'
      }
    }
});
	drawLine(date, ip);
	drawAge(age);
	drawJob(job);
}

function drawLine(date, ip){
	new Chart(document.getElementById("bar-chart"), {
  type: 'line',
  lineColor: "black",
  data: {
    labels: date,
    datasets: [{ 
        data: ip,
        label: "Daily visitors",
        backgroundColor: "#1a7501",
        fill: false
      }
    ]
  },
  options: {
    title: {
      display: false,
      text: 'Daily visitors of website'
    }
  }
});
}

function drawJob(job){
	new Chart(document.getElementById("job-chart"), {
    type: 'pie',
    data: {
      labels: ["AgriculturalIndustry", "CasualUser", "Consultant", "Researcher", "School&University"],
      datasets: [{
        label: "job",
        backgroundColor: ["#99a3c7", "#a3c799", "#037eb1", "#011a75", "#1a7501"],
        data: job
      }]
    },
    options: {
      title: {
        display: false,
        text: 'Occupation composition of the users'
      }
    }
});
}

function drawAge(age){
	new Chart(document.getElementById("age-chart"), {
    type: 'pie',
    data: {
      labels: ["18-30", "31-45", "46-65", "over65", "Under18"],
      datasets: [{
        label: "age",
        backgroundColor: ["#99a3c7", "#a3c799", "#037eb1", "#011a75", "#1a7501"],
        data: age
      }]
    },
    options: {
      title: {
        display: false,
        text: 'Age composition of the users'
      }
    }
});
}
