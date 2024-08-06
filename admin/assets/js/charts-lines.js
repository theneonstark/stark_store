const fetch_month = document.querySelectorAll(".fetch_per_month");
const fetch_day = document.querySelectorAll(".fetch_per_day");
const fetch_monthly_user = document.querySelectorAll(".fetch_monthly_users");
const fetch_per_day = document.querySelectorAll(".fetch_new_user");
const months = [];
const day = [];
const day_user = [];
const monthly_user = [];
fetch_month.forEach((e) => {
  months.push(e.value);
});
fetch_day.forEach((e) => {
  day.push(e.value);
});
fetch_monthly_user.forEach((e) => {
  monthly_user.push(e.value);
});
fetch_per_day.forEach((e) => {
  day_user.push(e.value);
});

//Monthly User
const lineConfig_month = {
  type: "line",
  data: {
    labels: months,
    datasets: [
      {
        label: "Total",
        backgroundColor: "#0694a2",
        borderColor: "#0694a2",
        data: monthly_user,
        fill: false,
      },
      {
        label: "Active",
        fill: false,
        backgroundColor: "#7e3af2",
        borderColor: "#7e3af2",
        data: [1],
      },
    ],
  },
  options: {
    responsive: true,
    legend: {
      display: false,
    },
    tooltips: {
      mode: "index",
      intersect: false,
    },
    hover: {
      mode: "nearest",
      intersect: true,
    },
    scales: {
      x: {
        display: true,
        scaleLabel: {
          display: true,
          labelString: "Month",
        },
      },
      y: {
        display: true,
        scaleLabel: {
          display: true,
          labelString: "Value",
        },
      },
    },
  },
};
//Per Day user
const lineConfig_days = {
  type: "line",
  data: {
    labels: day,
    datasets: [
      {
        label: "Total",
        backgroundColor: "#0694a2",
        borderColor: "#0694a2",
        data: day_user,
        fill: false,
      },
      {
        label: "Active",
        fill: false,
        backgroundColor: "#7e3af2",
        borderColor: "#7e3af2",
        data: [1],
      },
    ],
  },
  options: {
    responsive: true,
    legend: {
      display: false,
    },
    tooltips: {
      mode: "index",
      intersect: false,
    },
    hover: {
      mode: "nearest",
      intersect: true,
    },
    scales: {
      x: {
        display: true,
        scaleLabel: {
          display: true,
          labelString: "Month",
        },
      },
      y: {
        display: true,
        scaleLabel: {
          display: true,
          labelString: "Value",
        },
      },
    },
  },
};
const lineCtx = document.getElementById("line");
const line2Ctx = document.getElementById("line2");
window.myLine = new Chart(lineCtx, lineConfig_month);
window.myLine = new Chart(line2Ctx, lineConfig_days);
