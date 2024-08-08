const pieConfig = {
  type: "pie",
  data: {
    datasets: [
      {
        data: [33, 33, 33],
        backgroundColor: ["#0694a2", "#1c64f2", "#7e3af2",'#c0c'],
        label: "Dataset 1",
      },
    ],
    labels: ["Shoes", "Shirts", "Bags"],
  },
  options: {
    responsive: true,
    cutoutPercentage: 80,
    legend: {
      display: true,
    },
  },
};

// change this to the id of your chart element in HMTL
const pieCtx = document.getElementById("pie");
window.myPie = new Chart(pieCtx, pieConfig);
