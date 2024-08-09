const product_name = document.querySelectorAll(".product .product_name");
const product_val = document.querySelectorAll(".product .product_val");
const p_name = [];
const p_val = [];
product_name.forEach((e)=>{
  p_name.push(e.value);
  console.log(e.value)
})
product_val.forEach((e)=>{
  p_val.push(e.value)
})
const pieConfig = {
  type: "pie",
  data: {
    datasets: [
      {
        data: p_val,
        backgroundColor: ["#e02424", "#047481", "#7e3af2",'#c0c'],
        label: "Dataset 1",
      },
    ],
    labels: p_name,
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
