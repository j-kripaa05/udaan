// Bar Chart
const ctxBar = document.getElementById("barChart");

// Use dynamic data passed from the PHP file
new Chart(ctxBar, {
  type: "bar",
  data: {
    // Use the labels calculated in PHP (now dynamic)
    labels: chartLabels, 
    datasets: [{
      label: "Applications",
      // Use the dynamic data array passed from PHP
      data: dynamicChartData, 
      backgroundColor: "#7f00ff",
      borderRadius: 6
    }]
  },
  options: {
    responsive: true,
    scales: {
      y: { 
        beginAtZero: true,
        ticks: {
            // Force ticks to be integers only (no decimals)
            precision: 0,
            // Ensure ticks increment by whole numbers (no .5 steps)
            stepSize: 1 
        }
      }
    }
  }
});

// Pie Chart (Kept static as per original file structure)
const ctxPie = document.getElementById("pieChart");
new Chart(ctxPie, {
  type: "pie",
  data: {
    labels: ["Cooking", "Stitching", "IT", "Teaching", "Handcraft", "Coaching"],
    datasets: [{
      data: [20, 15, 25, 10, 15, 15],
      backgroundColor: ["#4F46E5", "#10B981", "#F59E0B", "#EF4444", "#8B5CF6", "#3B82F6"]
    }]
  },
  options: { responsive: true }
});