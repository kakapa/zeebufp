<template>
  <div class="space-y-6">
    <!-- Charts Row -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
      <!-- Monthly Trends -->
      <div class="bg-white rounded-lg shadow">
        <div class="p-6">
          <h3 class="text-lg font-semibold">Monthly Trends</h3>
          <p class="text-sm text-gray-500">
            Client registrations and contributions over time
          </p>
        </div>
        <div class="px-6 pb-6">
          <BarChart
            :chartData="monthlyChartData"
            :chartOptions="monthlyChartOptions"
          />
        </div>
      </div>

      <!-- Package Distribution -->
      <div class="bg-white rounded-lg shadow">
        <div class="p-6">
          <h3 class="text-lg font-semibold">Package Distribution</h3>
          <p class="text-sm text-gray-500">
            Current client distribution across packages
          </p>
        </div>
        <div class="px-6 pb-6">
          <PieChart
            :chartData="packageChartData"
            :chartOptions="packageChartOptions"
          />
        </div>
      </div>
    </div>

    <!-- Claims Trend -->
    <div class="bg-white rounded-lg shadow">
      <div class="p-6">
        <h3 class="text-lg font-semibold">Claims Processing Trend</h3>
        <p class="text-sm text-gray-500">
          Monthly claims submitted over the past 6 months
        </p>
      </div>
      <div class="px-6 pb-6">
        <LineChart
          :chartData="claimsChartData"
          :chartOptions="claimsChartOptions"
        />
      </div>
    </div>
  </div>
</template>

<script setup>
import BarChart from "@/Components/Charts/BarChart.vue";
import PieChart from "@/Components/Charts/PieChart.vue";
import LineChart from "@/Components/Charts/LineChart.vue";

const monthlyChartData = {
  labels: ["Jan", "Feb", "Mar", "Apr", "May", "Jun"],
  datasets: [
    {
      label: "New Clients",
      data: [65, 72, 81, 88, 95, 102],
      backgroundColor: "#8884d8",
    },
    {
      label: "Contributions ($)",
      data: [28000, 32000, 35000, 38000, 42000, 45000],
      backgroundColor: "#82ca9d",
    },
  ],
};

const monthlyChartOptions = {
  responsive: true,
  plugins: {
    legend: {
      position: "top",
    },
    title: {
      display: true,
      text: "Monthly Trends",
    },
  },
};

const packageChartData = {
  labels: ["Basic Plan", "Premium Plan", "Deluxe Plan"],
  datasets: [
    {
      label: "Package Distribution",
      data: [35, 45, 20],
      backgroundColor: ["#8884d8", "#82ca9d", "#ffc658"],
    },
  ],
};

const packageChartOptions = {
  responsive: true,
  plugins: {
    legend: {
      position: "top",
    },
    title: {
      display: true,
      text: "Package Distribution",
    },
  },
};

const claimsChartData = {
  labels: ["Jan", "Feb", "Mar", "Apr", "May", "Jun"],
  datasets: [
    {
      label: "Claims",
      data: [12, 8, 15, 10, 18, 23],
      borderColor: "#ff7300",
      backgroundColor: "#ff7300",
      fill: false,
      tension: 0.1,
    },
  ],
};

const claimsChartOptions = {
  responsive: true,
  plugins: {
    legend: {
      position: "top",
    },
    title: {
      display: true,
      text: "Claims Processing Trend",
    },
  },
};
</script>
