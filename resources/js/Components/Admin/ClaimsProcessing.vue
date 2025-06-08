<template>
  <div class="space-y-6">
    <!-- Header and Stats -->
    <div
      class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4"
    >
      <div>
        <h2 class="text-2xl font-bold">Claims Processing</h2>
        <p class="text-gray-600">Manage and process client claims</p>
      </div>
      <AddButton @click="showAddAccountDialog = true"> Add Claim </AddButton>
    </div>

    <!-- Summary Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
      <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center justify-between">
          <div>
            <p class="text-sm font-medium text-gray-600">Total Claims</p>
            <p class="text-2xl font-bold">{{ claims.length }}</p>
          </div>
          <Clock class="h-8 w-8 text-blue-600" />
        </div>
      </div>
      <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center justify-between">
          <div>
            <p class="text-sm font-medium text-gray-600">Pending Review</p>
            <p class="text-2xl font-bold">{{ pendingClaims.length }}</p>
          </div>
          <Clock class="h-8 w-8 text-yellow-600" />
        </div>
      </div>
      <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center justify-between">
          <div>
            <p class="text-sm font-medium text-gray-600">Approved</p>
            <p class="text-2xl font-bold">{{ approvedClaims.length }}</p>
          </div>
          <CheckCircle class="h-8 w-8 text-green-600" />
        </div>
      </div>
      <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center justify-between">
          <div>
            <p class="text-sm font-medium text-gray-600">Total Value</p>
            <p class="text-2xl font-bold">
              ${{ totalClaimsValue.toLocaleString() }}
            </p>
          </div>
          <DollarSign class="h-8 w-8 text-purple-600" />
        </div>
      </div>
    </div>

    <!-- Search -->
    <div class="bg-white rounded-lg shadow p-6">
      <div class="flex items-center space-x-2">
        <Search class="h-4 w-4 text-gray-400" />
        <input
          type="text"
          placeholder="Search claims by client name, ID, or type..."
          v-model="searchTerm"
          class="flex-1 px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
        />
      </div>
    </div>

    <!-- Claims Table -->
    <div class="bg-white rounded-lg shadow">
      <div class="p-6 border-b">
        <h3 class="text-lg font-semibold">
          Claims Management ({{ filteredClaims.length }})
        </h3>
        <p class="text-sm text-gray-500">
          Process and manage all client claims
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
                  Claim ID
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
                  Type
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
                  Status
                </th>
                <th
                  scope="col"
                  class="py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                >
                  Submission Date
                </th>
                <th
                  scope="col"
                  class="py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                >
                  Assigned To
                </th>
                <th
                  scope="col"
                  class="py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                >
                  Actions
                </th>
              </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
              <tr v-for="claim in filteredClaims" :key="claim.id">
                <td class="py-4 whitespace-nowrap font-mono">
                  {{ claim.id }}
                </td>
                <td class="py-4 whitespace-nowrap">
                  <div>
                    <div class="font-medium">{{ claim.clientName }}</div>
                    <div class="text-sm text-gray-500">
                      {{ claim.clientId }}
                    </div>
                  </div>
                </td>
                <td class="py-4 whitespace-nowrap">
                  {{ claim.claimType }}
                </td>
                <td class="py-4 whitespace-nowrap">
                  ${{ claim.amount.toLocaleString() }}
                </td>
                <td class="py-4 whitespace-nowrap">
                  <div class="flex items-center gap-2">
                    <component :is="getStatusIcon(claim.status)" />
                    <span
                      :class="getStatusBadge(claim.status)"
                      class="px-2 py-1 rounded-full text-xs"
                    >
                      {{ claim.status }}
                    </span>
                  </div>
                </td>
                <td class="py-4 whitespace-nowrap">
                  {{ claim.submissionDate }}
                </td>
                <td class="py-4 whitespace-nowrap">
                  {{ claim.assignedTo }}
                </td>
                <td class="py-4 whitespace-nowrap">
                  <div class="flex space-x-2">
                    <button
                      class="p-2 border border-gray-300 rounded-md hover:bg-gray-50"
                    >
                      <Eye class="h-4 w-4" />
                    </button>
                    <button
                      class="p-2 border border-gray-300 rounded-md hover:bg-gray-50 text-green-600"
                    >
                      <CheckCircle class="h-4 w-4" />
                    </button>
                    <button
                      class="p-2 border border-gray-300 rounded-md hover:bg-gray-50 text-red-600"
                    >
                      <XCircle class="h-4 w-4" />
                    </button>
                  </div>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>

    <!-- New Claim Dialog -->
    <div
      v-if="showDialog"
      class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center p-4 z-50"
    >
      <div
        class="bg-white rounded-lg shadow-xl max-w-md w-full max-h-[90vh] overflow-y-auto"
      >
        <div class="p-6 border-b">
          <h3 class="text-lg font-semibold">Create New Claim</h3>
          <p class="text-sm text-gray-500">
            Enter claim details for processing.
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
              v-model="newClaim.clientId"
              type="text"
              class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
              placeholder="Enter client ID"
            />
          </div>
          <div>
            <label
              for="claimType"
              class="block text-sm font-medium text-gray-700 mb-1"
              >Claim Type</label
            >
            <select
              id="claimType"
              v-model="newClaim.claimType"
              class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
            >
              <option value="" disabled selected>Select claim type</option>
              <option value="Death Benefit">Death Benefit</option>
              <option value="Funeral Expenses">Funeral Expenses</option>
              <option value="Emergency Fund">Emergency Fund</option>
              <option value="Medical Expenses">Medical Expenses</option>
            </select>
          </div>
          <div>
            <label
              for="amount"
              class="block text-sm font-medium text-gray-700 mb-1"
              >Claim Amount ($)</label
            >
            <input
              id="amount"
              v-model="newClaim.amount"
              type="number"
              class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
              placeholder="Enter claim amount"
            />
          </div>
          <div>
            <label
              for="description"
              class="block text-sm font-medium text-gray-700 mb-1"
              >Description</label
            >
            <textarea
              id="description"
              v-model="newClaim.description"
              rows="3"
              class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
              placeholder="Enter claim description"
            ></textarea>
          </div>
          <div>
            <label
              for="assignedTo"
              class="block text-sm font-medium text-gray-700 mb-1"
              >Assign To</label
            >
            <select
              id="assignedTo"
              v-model="newClaim.assignedTo"
              class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
            >
              <option value="" disabled selected>Assign to officer</option>
              <option value="Claims Officer 1">Claims Officer 1</option>
              <option value="Claims Officer 2">Claims Officer 2</option>
              <option value="Senior Claims Manager">
                Senior Claims Manager
              </option>
            </select>
          </div>
          <div class="flex space-x-3 pt-4">
            <button
              @click="showDialog = false"
              class="flex-1 px-4 py-2 border border-gray-300 rounded-md hover:bg-gray-50"
            >
              Cancel
            </button>
            <button
              @click="handleAddClaim"
              class="flex-1 px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700"
            >
              Create Claim
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, computed } from "vue";
import {
  Plus,
  Eye,
  CheckCircle,
  XCircle,
  Clock,
  DollarSign,
  Search,
} from "lucide-vue-next";
import AddButton from "../Ui/AddButton.vue";

const showDialog = ref(false);
const searchTerm = ref("");
const claims = ref([
  {
    id: "C-2024-001",
    clientId: "C001",
    clientName: "John Smith",
    claimType: "Death Benefit",
    amount: 50000,
    status: "Pending Review",
    submissionDate: "2024-01-15",
    description: "Claim for death benefit following natural causes",
    documents: ["death_certificate.pdf", "medical_report.pdf"],
    assignedTo: "Claims Officer 1",
  },
  {
    id: "C-2024-002",
    clientId: "C002",
    clientName: "Maria Garcia",
    claimType: "Funeral Expenses",
    amount: 15000,
    status: "Approved",
    submissionDate: "2024-01-10",
    description: "Funeral and burial expenses claim",
    documents: ["funeral_invoice.pdf", "burial_receipt.pdf"],
    assignedTo: "Claims Officer 2",
  },
  {
    id: "C-2024-003",
    clientId: "C003",
    clientName: "Robert Johnson",
    claimType: "Emergency Fund",
    amount: 5000,
    status: "Under Investigation",
    submissionDate: "2024-01-20",
    description: "Emergency financial assistance request",
    documents: ["emergency_request.pdf"],
    assignedTo: "Claims Officer 1",
  },
]);

const newClaim = ref({
  clientId: "",
  claimType: "",
  amount: "",
  description: "",
  assignedTo: "",
});

const filteredClaims = computed(() => {
  const term = searchTerm.value.toLowerCase();
  return claims.value.filter(
    (claim) =>
      claim.clientName.toLowerCase().includes(term) ||
      claim.id.toLowerCase().includes(term) ||
      claim.claimType.toLowerCase().includes(term)
  );
});

const totalClaimsValue = computed(() =>
  claims.value.reduce((sum, claim) => sum + claim.amount, 0)
);

const approvedClaims = computed(() =>
  claims.value.filter((claim) => claim.status === "Approved")
);

const pendingClaims = computed(() =>
  claims.value.filter((claim) => claim.status === "Pending Review")
);

const handleAddClaim = () => {
  const id = `C-2024-${String(claims.value.length + 1).padStart(3, "0")}`;
  const claimData = {
    ...newClaim.value,
    id,
    amount: parseInt(newClaim.value.amount),
    status: "Pending Review",
    submissionDate: new Date().toISOString().split("T")[0],
    documents: [],
    clientName: `Client ${newClaim.value.clientId}`,
  };
  claims.value.push(claimData);
  newClaim.value = {
    clientId: "",
    claimType: "",
    amount: "",
    description: "",
    assignedTo: "",
  };
  showDialog.value = false;
};

const getStatusBadge = (status) => {
  const variants = {
    "Pending Review": "bg-yellow-100 text-yellow-800",
    Approved: "bg-green-100 text-green-800",
    Rejected: "bg-red-100 text-red-800",
    "Under Investigation": "bg-blue-100 text-blue-800",
    "Processing Payment": "bg-purple-100 text-purple-800",
  };
  return variants[status] || "bg-gray-100 text-gray-800";
};

const getStatusIcon = (status) => {
  switch (status) {
    case "Approved":
      return CheckCircle;
    case "Rejected":
      return XCircle;
    case "Processing Payment":
      return DollarSign;
    default:
      return Clock;
  }
};
</script>
