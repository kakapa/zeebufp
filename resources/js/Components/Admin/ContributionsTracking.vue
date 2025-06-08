<template>
  <div class="space-y-6">
    <!-- Header and Stats -->
    <div
      class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4"
    >
      <div>
        <h2 class="text-2xl font-bold">Contributions Tracking</h2>
        <p class="text-gray-600">
          Monitor all client payments and contributions
        </p>
      </div>
      <AddButton @click="showAddAccountDialog = true">
        Add Contribution
      </AddButton>
    </div>

    <!-- Summary Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
      <div class="bg-white rounded-lg shadow p-6">
        <h3 class="text-lg font-semibold">Total Contributions</h3>
        <div class="mt-2">
          <div class="text-3xl font-bold text-green-600">
            ${{ totalContributions.toLocaleString() }}
          </div>
          <p class="text-sm text-gray-600">All time</p>
        </div>
      </div>
      <div class="bg-white rounded-lg shadow p-6">
        <h3 class="text-lg font-semibold">This Month</h3>
        <div class="mt-2">
          <div class="text-3xl font-bold text-blue-600">
            ${{ monthlyContributions.toLocaleString() }}
          </div>
          <p class="text-sm text-gray-600">January 2024</p>
        </div>
      </div>
      <div class="bg-white rounded-lg shadow p-6">
        <h3 class="text-lg font-semibold">Pending Payments</h3>
        <div class="mt-2">
          <div class="text-3xl font-bold text-yellow-600">
            {{ contributions.filter((c) => c.status === "Pending").length }}
          </div>
          <p class="text-sm text-gray-600">Awaiting processing</p>
        </div>
      </div>
    </div>

    <!-- Filters -->
    <div class="bg-white rounded-lg shadow p-6">
      <div class="flex flex-col sm:flex-row gap-4">
        <div class="flex items-center space-x-2 flex-1">
          <Search class="h-4 w-4 text-gray-400" />
          <input
            type="text"
            placeholder="Search by client name, ID, or reference..."
            v-model="searchTerm"
            class="flex-1 px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
          />
        </div>
        <div class="flex items-center space-x-2">
          <Filter class="h-4 w-4 text-gray-400" />
          <select
            v-model="statusFilter"
            class="w-40 px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
          >
            <option value="all">All Status</option>
            <option value="completed">Completed</option>
            <option value="pending">Pending</option>
            <option value="failed">Failed</option>
          </select>
        </div>
      </div>
    </div>

    <!-- Contributions Table -->
    <div class="bg-white rounded-lg shadow">
      <div class="p-6 border-b">
        <h3 class="text-lg font-semibold">
          Payment History ({{ filteredContributions.length }})
        </h3>
        <p class="text-sm text-gray-500">
          Complete record of all contributions and payments
        </p>
      </div>
      <div class="p-6">
        <div class="overflow-x-auto">
          <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
              <tr>
                <th
                  scope="col"
                  class="py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                >
                  Payment ID
                </th>
                <th
                  scope="col"
                  class="py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                >
                  Client
                </th>
                <th
                  scope="col"
                  class="py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                >
                  Package
                </th>
                <th
                  scope="col"
                  class="py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                >
                  Amount
                </th>
                <th
                  scope="col"
                  class="py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                >
                  Date
                </th>
                <th
                  scope="col"
                  class="py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                >
                  Method
                </th>
                <th
                  scope="col"
                  class="py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                >
                  Reference
                </th>
                <th
                  scope="col"
                  class="py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                >
                  Status
                </th>
              </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
              <tr
                v-for="contribution in filteredContributions"
                :key="contribution.id"
              >
                <td class="py-4 whitespace-nowrap font-mono">
                  {{ contribution.id }}
                </td>
                <td class="py-4 whitespace-nowrap">
                  <div>
                    <div class="font-medium">{{ contribution.clientName }}</div>
                    <div class="text-sm text-gray-500">
                      {{ contribution.clientId }}
                    </div>
                  </div>
                </td>
                <td class="py-4 whitespace-nowrap">
                  {{ contribution.package }}
                </td>
                <td class="py-4 whitespace-nowrap font-mono">
                  ${{ contribution.amount }}
                </td>
                <td class="py-4 whitespace-nowrap">
                  {{ contribution.date }}
                </td>
                <td class="py-4 whitespace-nowrap">
                  {{ contribution.method }}
                </td>
                <td class="py-4 whitespace-nowrap font-mono text-sm">
                  {{ contribution.reference }}
                </td>
                <td class="py-4 whitespace-nowrap">
                  <span
                    :class="getStatusBadge(contribution.status)"
                    class="px-2 py-1 rounded-full text-xs"
                  >
                    {{ contribution.status }}
                  </span>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>

    <!-- New Payment Dialog -->
    <div
      v-if="showDialog"
      class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center p-4 z-50"
    >
      <div
        class="bg-white rounded-lg shadow-xl max-w-md w-full max-h-[90vh] overflow-y-auto"
      >
        <div class="p-6 border-b">
          <h3 class="text-lg font-semibold">Record New Payment</h3>
          <p class="text-sm text-gray-500">
            Add a new payment or contribution record.
          </p>
        </div>
        <div class="p-6 space-y-4">
          <div>
            <label
              for="clientId"
              class="block text-sm font-medium text-gray-700 mb-1"
              >Client ID</label
            >
            <input
              id="clientId"
              v-model="newPayment.clientId"
              type="text"
              class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
              placeholder="Enter client ID"
            />
          </div>
          <div>
            <label
              for="amount"
              class="block text-sm font-medium text-gray-700 mb-1"
              >Amount ($)</label
            >
            <input
              id="amount"
              v-model="newPayment.amount"
              type="number"
              class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
              placeholder="Enter payment amount"
            />
          </div>
          <div>
            <label
              for="method"
              class="block text-sm font-medium text-gray-700 mb-1"
              >Payment Method</label
            >
            <select
              id="method"
              v-model="newPayment.method"
              class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
            >
              <option value="" disabled selected>Select payment method</option>
              <option value="Bank Transfer">Bank Transfer</option>
              <option value="Credit Card">Credit Card</option>
              <option value="Cash">Cash</option>
              <option value="Check">Check</option>
            </select>
          </div>
          <div>
            <label
              for="reference"
              class="block text-sm font-medium text-gray-700 mb-1"
              >Reference Number</label
            >
            <input
              id="reference"
              v-model="newPayment.reference"
              type="text"
              class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
              placeholder="Enter reference number"
            />
          </div>
          <div class="flex space-x-3 pt-4">
            <button
              @click="showDialog = false"
              class="flex-1 px-4 py-2 border border-gray-300 rounded-md hover:bg-gray-50"
            >
              Cancel
            </button>
            <button
              @click="handleAddPayment"
              class="flex-1 px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700"
            >
              Record Payment
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, computed } from "vue";
import { Plus, Download, Search, Filter } from "lucide-vue-next";
import AddButton from "../Ui/AddButton.vue";

const showDialog = ref(false);
const searchTerm = ref("");
const statusFilter = ref("all");
const contributions = ref([
  {
    id: "PAY001",
    clientId: "C001",
    clientName: "John Smith",
    package: "Premium Plan",
    amount: 100,
    date: "2024-01-15",
    method: "Bank Transfer",
    status: "Completed",
    reference: "TXN789123456",
  },
  {
    id: "PAY002",
    clientId: "C002",
    clientName: "Maria Garcia",
    package: "Basic Plan",
    amount: 50,
    date: "2024-01-14",
    method: "Credit Card",
    status: "Completed",
    reference: "TXN789123457",
  },
  {
    id: "PAY003",
    clientId: "C003",
    clientName: "Robert Johnson",
    package: "Deluxe Plan",
    amount: 200,
    date: "2024-01-13",
    method: "Bank Transfer",
    status: "Pending",
    reference: "TXN789123458",
  },
  {
    id: "PAY004",
    clientId: "C001",
    clientName: "John Smith",
    package: "Premium Plan",
    amount: 100,
    date: "2023-12-15",
    method: "Bank Transfer",
    status: "Completed",
    reference: "TXN789123459",
  },
]);

const newPayment = ref({
  clientId: "",
  amount: "",
  method: "",
  reference: "",
});

const filteredContributions = computed(() => {
  const term = searchTerm.value.toLowerCase();
  const status = statusFilter.value.toLowerCase();

  return contributions.value.filter((contribution) => {
    const matchesSearch =
      contribution.clientName.toLowerCase().includes(term) ||
      contribution.clientId.toLowerCase().includes(term) ||
      contribution.reference.toLowerCase().includes(term);
    const matchesStatus =
      status === "all" || contribution.status.toLowerCase() === status;
    return matchesSearch && matchesStatus;
  });
});

const totalContributions = computed(() =>
  contributions.value.reduce(
    (sum, c) => (c.status === "Completed" ? sum + c.amount : sum),
    0
  )
);

const monthlyContributions = computed(() =>
  contributions.value
    .filter((c) => c.date.startsWith("2024-01") && c.status === "Completed")
    .reduce((sum, c) => sum + c.amount, 0)
);

const handleAddPayment = () => {
  const id = `PAY${String(contributions.value.length + 1).padStart(3, "0")}`;
  const paymentData = {
    ...newPayment.value,
    id,
    clientName: "New Client",
    package: "Basic Plan",
    amount: parseInt(newPayment.value.amount),
    date: new Date().toISOString().split("T")[0],
    status: "Pending",
  };
  contributions.value.push(paymentData);
  newPayment.value = { clientId: "", amount: "", method: "", reference: "" };
  showDialog.value = false;
};

const getStatusBadge = (status) => {
  const variants = {
    Completed: "bg-green-100 text-green-800",
    Pending: "bg-yellow-100 text-yellow-800",
    Failed: "bg-red-100 text-red-800",
  };
  return variants[status] || "bg-gray-100 text-gray-800";
};
</script>
