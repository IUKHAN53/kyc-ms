document.getElementById("toggleSidebar").addEventListener("click", function () {
  document.getElementById("sidebar").classList.toggle("collapsed");
  document.getElementById("content").classList.toggle("collapsed");
});

// Example starter JavaScript for disabling form submissions if there are invalid fields
(() => {
    'use strict'
  
    // Fetch all the forms we want to apply custom Bootstrap validation styles to
    const forms = document.querySelectorAll('.needs-validation')
  
    // Loop over them and prevent submission
    Array.from(forms).forEach(form => {
      form.addEventListener('submit', event => {
        if (!form.checkValidity()) {
          event.preventDefault()
          event.stopPropagation()
        }
  
        form.classList.add('was-validated')
      }, false)
    })
  })()

// Chart for month
function createLineChart(chartId, dataValues) {
  const ctx = document.getElementById(chartId).getContext("2d");

  const data = {
      labels: ["Jun 23", "Jul 23", "Ago 23", "Set 23", "Out 23", "Nov 23", "Dez 23", 
               "Jan 24", "Fev 24", "Mar 24", "Abr 24", "Mai 24", "Jul 24"],
      datasets: [{
          label: "Minha Jornada",
          data: dataValues,  // Custom values
          fill: true,
          borderColor: "#246CF9",
          backgroundColor: "rgba(36, 108, 249, 0.2)",
          tension: 0.4,
          pointRadius: 5,
          pointBackgroundColor: "#246CF9",
          pointBorderColor: "#fff",
          pointHoverRadius: 7
      }]
  };

  const config = {
      type: "line",
      data: data,
      options: {
          responsive: true,
          maintainAspectRatio: false,
          scales: {
              y: {
                  beginAtZero: true,
                  ticks: {
                      callback: function(value) {
                          return value >= 1000 ? (value / 1000) + "k" : value;
                      }
                  }
              }
          },
          plugins: {
              legend: { display: false }
          }
      }
  };

  new Chart(ctx, config);
}

// Call function with **custom** values
createLineChart("myChart", [9000, 5000, 15000, 40000, 30000, 15000, 12000, 11000, 13000, 17000, 22000, 35000, 0]);

// Chart 2 circle
function createProgressChart(chartId, percentage) {
  const ctx = document.getElementById(chartId).getContext("2d");

  new Chart(ctx, {
      type: "doughnut",
      data: {
          datasets: [{
              data: [percentage, 100 - percentage],
              backgroundColor: ["#246CF9", "#E3EEFF"],
              borderWidth: 5
          }]
      },
      options: {
          responsive: false,
          cutout: "60%", 
          plugins: {
              tooltip: { enabled: false },
              legend: { display: false }
          }
      }
  });

  // Display percentage in the center
  const canvas = document.getElementById(chartId);
  const ctx2 = canvas.getContext("2d");

  ctx2.font = "bold 18px Arial";
  ctx2.fillStyle = "#000";
  ctx2.textAlign = "center";
  ctx2.textBaseline = "middle";
  ctx2.fillText(percentage + "%", canvas.width / 2, canvas.height / 2);
}

// Initialize charts
createProgressChart("contatosChart", 50);
createProgressChart("vendasChart", 20);

// Chart 1st cirle
function createGaugeChart(chartId, value, increase, decrease) {
  const ctx = document.getElementById(chartId).getContext("2d");

  new Chart(ctx, {
      type: "doughnut",
      data: {
          datasets: [{
              data: [value, 100 - value],
              backgroundColor: ["#CFFAE2", "#F0F5F9"], 
              borderWidth: 0,
              circumference: 180,
              rotation: 270
          }]
      },
      options: {
          responsive: false,
          cutout: "80%", 
          plugins: {
              tooltip: { enabled: false },
              legend: { display: false }
          }
      }
  });

  // Update text values dynamically
  document.getElementById("conversionValue").textContent = value;
  document.getElementById("weeklyIncrease").textContent = `+${increase}%`;
  document.getElementById("weeklyDecrease").textContent = `-${decrease}%`;
}

// Call function with **custom** values
createGaugeChart("conversoesChart", 20, 5.5, 2.3);

// Table with pagianation
