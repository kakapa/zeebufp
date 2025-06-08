<template>
  <div class="space-y-6">
    <!-- Header and Search -->
    <div
      class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4"
    >
      <div>
        <h2 class="text-2xl font-bold">Client Account Management</h2>
        <p class="text-gray-600">
          Manage client funeral policy accounts and subscriptions
        </p>
      </div>
      <AddButton @click="showAddAccountDialog = true"> Add Account </AddButton>
    </div>

    <!-- Add Account Dialog -->
    <div
      v-if="showAddAccountDialog"
      class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50"
    >
      <div
        class="bg-white rounded-lg p-6 max-w-md w-full max-h-[90vh] overflow-y-auto"
      >
        <div class="space-y-4">
          <div>
            <h3 class="text-lg font-bold">Add New Account</h3>
            <p class="text-gray-600">
              Enter account information to register a new funeral policy
              account.
            </p>
          </div>

          <div>
            <label
              for="clientId"
              class="block text-sm font-medium text-gray-700 mb-1"
              >Client ID</label
            >
            <input
              id="clientId"
              v-model="newAccount.clientId"
              class="w-full px-3 py-2 border border-gray-300 rounded"
              placeholder="Enter client ID"
            />
          </div>

          <div>
            <label
              for="mainPackage"
              class="block text-sm font-medium text-gray-700 mb-1"
              >Main Package</label
            >
            <select
              v-model="newAccount.mainPackageId"
              class="w-full px-3 py-2 border border-gray-300 rounded"
            >
              <option value="">Select a main package</option>
              <option v-for="pkg in packages" :key="pkg.id" :value="pkg.id">
                {{ pkg.name }} - ${{ pkg.monthlyFee }}/month
              </option>
            </select>
          </div>

          <div>
            <label
              for="monthlyPaymentDay"
              class="block text-sm font-medium text-gray-700 mb-1"
              >Monthly Payment Day</label
            >
            <input
              id="monthlyPaymentDay"
              type="number"
              v-model="newAccount.monthlyPaymentDay"
              class="w-full px-3 py-2 border border-gray-300 rounded"
              placeholder="Enter payment day"
            />
          </div>

          <div class="flex justify-end gap-2 pt-2">
            <button
              @click="showAddAccountDialog = false"
              class="px-4 py-2 border border-gray-300 rounded hover:bg-gray-50"
            >
              Cancel
            </button>
            <button
              @click="handleAddAccount"
              class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700"
            >
              Add Account
            </button>
          </div>
        </div>
      </div>
    </div>

    <!-- Search -->
    <div class="bg-white rounded-lg shadow p-6">
      <div class="flex items-center space-x-2">
        <SearchIcon class="h-4 w-4 text-gray-400" />
        <input
          type="text"
          placeholder="Search accounts by account number or client ID..."
          v-model="searchTerm"
          class="flex-1 px-3 py-2 border border-gray-300 rounded"
        />
      </div>
    </div>

    <!-- Accounts Table -->
    <div class="bg-white rounded-lg shadow overflow-hidden">
      <div class="p-6">
        <h3 class="text-xl font-bold">
          Funeral Policy Accounts ({{ filteredAccounts.length }})
        </h3>
        <p class="text-gray-600">
          All client funeral policy accounts and their details
        </p>
      </div>

      <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
          <thead class="bg-gray-50 sticky top-0">
            <tr>
              <th
                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider min-w-[140px]"
              >
                Account Number
              </th>
              <th
                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider min-w-[100px]"
              >
                Client ID
              </th>
              <th
                class="hidden md:table-cell px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider min-w-[120px]"
              >
                Main Package
              </th>
              <th
                class="hidden lg:table-cell px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider min-w-[100px]"
              >
                Payment Day
              </th>
              <th
                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider min-w-[100px]"
              >
                Status
              </th>
              <th
                class="hidden xl:table-cell px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider min-w-[120px]"
              >
                Monthly Fee
              </th>
              <th
                class="hidden lg:table-cell px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider min-w-[120px]"
              >
                Coverage
              </th>
              <th
                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider min-w-[120px] sticky right-0 bg-gray-50"
              >
                Actions
              </th>
            </tr>
          </thead>
          <tbody class="bg-white divide-y divide-gray-200">
            <tr v-for="account in filteredAccounts" :key="account.id">
              <td class="px-6 py-4 whitespace-nowrap text-sm font-mono">
                {{ account.accountNumber }}
              </td>
              <td class="px-6 py-4 whitespace-nowrap text-sm font-mono">
                {{ account.clientId }}
              </td>
              <td
                class="hidden md:table-cell px-6 py-4 whitespace-nowrap text-sm"
              >
                {{ account.mainPackage.name }}
              </td>
              <td
                class="hidden lg:table-cell px-6 py-4 whitespace-nowrap text-sm"
              >
                {{ account.monthlyPaymentDay }}
              </td>
              <td class="px-6 py-4 whitespace-nowrap">
                <span :class="getStatusBadge(account.status)">
                  {{ account.status }}
                </span>
              </td>
              <td
                class="hidden xl:table-cell px-6 py-4 whitespace-nowrap text-sm"
              >
                ${{ account.totalMonthlyFee }}
              </td>
              <td
                class="hidden lg:table-cell px-6 py-4 whitespace-nowrap text-sm"
              >
                ${{ account.totalCoverageAmount.toLocaleString() }}
              </td>
              <td class="px-6 py-4 whitespace-nowrap sticky right-0 bg-white">
                <div class="flex space-x-1">
                  <button
                    @click="selectedAccount = account"
                    class="p-2 border border-gray-300 rounded hover:bg-gray-50"
                  >
                    <EyeIcon class="h-3 w-3" />
                  </button>
                  <button
                    @click="downloadPolicy(account)"
                    class="p-2 border border-gray-300 rounded hover:bg-gray-50"
                  >
                    <DownloadIcon class="h-3 w-3" />
                  </button>
                  <button
                    @click="handleDeleteAccount(account.id)"
                    class="p-2 border border-gray-300 rounded hover:bg-gray-50 text-red-600 hidden sm:flex"
                  >
                    <Trash2Icon class="h-3 w-3" />
                  </button>
                </div>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>

    <!-- Account Detail View -->
    <div
      v-if="selectedAccount"
      class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50"
    >
      <div
        class="bg-white rounded-lg p-6 max-w-4xl w-full max-h-[90vh] overflow-y-auto"
      >
        <div class="flex justify-between items-start mb-4">
          <div>
            <h3 class="text-xl font-bold">
              Account Details - {{ selectedAccount.accountNumber }}
            </h3>
            <p class="text-gray-600">
              Detailed view of the funeral policy account
            </p>
          </div>
          <button
            @click="selectedAccount = null"
            class="text-gray-500 hover:text-gray-700"
          >
            <XIcon class="h-5 w-5" />
          </button>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
          <!-- Account Information -->
          <div class="bg-white rounded-lg shadow p-6">
            <h4 class="text-lg font-bold mb-4">Account Information</h4>
            <div class="space-y-4">
              <div>
                <label class="text-sm font-medium text-gray-500 block"
                  >Account Number</label
                >
                <p class="font-mono">{{ selectedAccount.accountNumber }}</p>
              </div>
              <div>
                <label class="text-sm font-medium text-gray-500 block"
                  >Client ID</label
                >
                <p class="font-mono">{{ selectedAccount.clientId }}</p>
              </div>
              <div>
                <label class="text-sm font-medium text-gray-500 block"
                  >Status</label
                >
                <span :class="getStatusBadge(selectedAccount.status)">
                  {{ selectedAccount.status }}
                </span>
              </div>
              <div>
                <label class="text-sm font-medium text-gray-500 block"
                  >Created Date</label
                >
                <p>{{ selectedAccount.createdDate }}</p>
              </div>
              <div>
                <label class="text-sm font-medium text-gray-500 block"
                  >Monthly Payment Day</label
                >
                <p>{{ selectedAccount.monthlyPaymentDay }}</p>
              </div>
            </div>
          </div>

          <!-- Package Information -->
          <div class="bg-white rounded-lg shadow p-6">
            <h4 class="text-lg font-bold mb-4">Package Information</h4>
            <div class="space-y-4">
              <div>
                <label class="text-sm font-medium text-gray-500 block"
                  >Main Package</label
                >
                <p class="font-medium">
                  {{ selectedAccount.mainPackage.name }}
                </p>
                <p class="text-sm text-gray-600">
                  ${{ selectedAccount.mainPackage.monthlyFee }}/month
                </p>
                <p class="text-sm text-gray-600">
                  Coverage: ${{
                    selectedAccount.mainPackage.coverageAmount.toLocaleString()
                  }}
                </p>
              </div>

              <div v-if="selectedAccount.additionalPackages.length > 0">
                <label class="text-sm font-medium text-gray-500 block"
                  >Additional Packages</label
                >
                <div
                  v-for="pkg in selectedAccount.additionalPackages"
                  :key="pkg.id"
                  class="mt-2 p-2 bg-gray-50 rounded"
                >
                  <p class="font-medium">{{ pkg.name }}</p>
                  <p class="text-sm text-gray-600">
                    ${{ pkg.monthlyFee }}/month
                  </p>
                </div>
              </div>

              <div class="pt-2 border-t">
                <label class="text-sm font-medium text-gray-500 block"
                  >Total Monthly Fee</label
                >
                <p class="text-lg font-bold">
                  ${{ selectedAccount.totalMonthlyFee }}
                </p>
              </div>
              <div>
                <label class="text-sm font-medium text-gray-500 block"
                  >Total Coverage</label
                >
                <p class="text-lg font-bold">
                  ${{ selectedAccount.totalCoverageAmount.toLocaleString() }}
                </p>
              </div>
            </div>
          </div>
        </div>

        <div class="flex justify-between pt-6">
          <button
            @click="downloadPolicy(selectedAccount)"
            class="flex items-center gap-2 px-4 py-2 border border-gray-300 rounded hover:bg-gray-50"
          >
            <DownloadIcon class="h-4 w-4" />
            Download Policy Document
          </button>
          <div class="space-x-2">
            <button
              @click="selectedAccount = null"
              class="px-4 py-2 border border-gray-300 rounded hover:bg-gray-50"
            >
              Close
            </button>
            <button
              class="flex items-center gap-2 px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700"
            >
              <EditIcon class="h-4 w-4" />
              Edit Account
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
  EyeIcon,
  DownloadIcon,
  Trash2Icon,
  PlusIcon,
  SearchIcon,
  XIcon,
  EditIcon,
} from "lucide-vue-next";
import AddButton from "../Ui/AddButton.vue";

// Types
const Package = {
  id: String,
  name: String,
  monthlyFee: Number,
  coverageAmount: Number,
  benefits: Array,
};

const FuneralAccount = {
  id: String,
  clientId: String,
  accountNumber: String,
  mainPackage: Object,
  additionalPackages: Array,
  monthlyPaymentDay: Number,
  status: String,
  createdDate: String,
  totalMonthlyFee: Number,
  totalCoverageAmount: Number,
  lastPaymentDate: String,
  nextPaymentDate: String,
};

// Data
const packages = ref([
  {
    id: "P001",
    name: "Basic Funeral Plan",
    monthlyFee: 50,
    coverageAmount: 10000,
    benefits: ["Basic funeral services", "Cremation or burial"],
  },
  {
    id: "P002",
    name: "Standard Funeral Plan",
    monthlyFee: 100,
    coverageAmount: 25000,
    benefits: ["Standard funeral services", "Cremation or burial", "Obituary"],
  },
  {
    id: "P003",
    name: "Premium Funeral Plan",
    monthlyFee: 200,
    coverageAmount: 50000,
    benefits: [
      "Premium funeral services",
      "Cremation or burial",
      "Obituary",
      "Grave marker",
    ],
  },
]);

const accounts = ref([
  {
    id: "A001",
    clientId: "C001",
    accountNumber: "ACC123456",
    mainPackage: packages.value[0],
    additionalPackages: [],
    monthlyPaymentDay: 15,
    status: "Active",
    createdDate: "2024-01-05",
    totalMonthlyFee: 50,
    totalCoverageAmount: 10000,
    lastPaymentDate: "2024-01-15",
    nextPaymentDate: "2024-02-15",
  },
  {
    id: "A002",
    clientId: "C002",
    accountNumber: "ACC789012",
    mainPackage: packages.value[1],
    additionalPackages: [packages.value[0]],
    monthlyPaymentDay: 20,
    status: "Active",
    createdDate: "2024-01-10",
    totalMonthlyFee: 150,
    totalCoverageAmount: 35000,
    lastPaymentDate: "2024-01-20",
    nextPaymentDate: "2024-02-20",
  },
  {
    id: "A003",
    clientId: "C003",
    accountNumber: "ACC345678",
    mainPackage: packages.value[2],
    additionalPackages: [],
    monthlyPaymentDay: 1,
    status: "Suspended",
    createdDate: "2024-01-15",
    totalMonthlyFee: 200,
    totalCoverageAmount: 50000,
    lastPaymentDate: "2023-12-01",
    nextPaymentDate: "2024-02-01",
  },
]);

const searchTerm = ref("");
const selectedAccount = ref(null);
const showAddAccountDialog = ref(false);
const newAccount = ref({
  clientId: "",
  mainPackageId: "",
  additionalPackageIds: [],
  monthlyPaymentDay: 1,
});

// Computed
const filteredAccounts = computed(() => {
  const term = searchTerm.value.toLowerCase();
  return accounts.value.filter(
    (account) =>
      account.accountNumber.toLowerCase().includes(term) ||
      account.clientId.toLowerCase().includes(term)
  );
});

// Methods
const getStatusBadge = (status) => {
  const variants = {
    Active: "bg-green-100 text-green-800 px-2 py-1 rounded text-xs",
    Suspended: "bg-red-100 text-red-800 px-2 py-1 rounded text-xs",
    Cancelled: "bg-gray-100 text-gray-800 px-2 py-1 rounded text-xs",
  };
  return (
    variants[status] || "bg-gray-100 text-gray-800 px-2 py-1 rounded text-xs"
  );
};

const downloadPolicy = (account) => {
  alert(`Downloading policy document for account ${account.accountNumber}`);
};

const handleAddAccount = () => {
  const id = `A${String(accounts.value.length + 1).padStart(3, "0")}`;
  const mainPackage = packages.value.find(
    (p) => p.id === newAccount.value.mainPackageId
  );
  const additionalPackages = packages.value.filter((p) =>
    newAccount.value.additionalPackageIds.includes(p.id)
  );

  if (!mainPackage) {
    alert("Please select a main package.");
    return;
  }

  const totalMonthlyFee =
    mainPackage.monthlyFee +
    additionalPackages.reduce((sum, pkg) => sum + pkg.monthlyFee, 0);
  const totalCoverageAmount =
    mainPackage.coverageAmount +
    additionalPackages.reduce((sum, pkg) => sum + pkg.coverageAmount, 0);

  const newAccountData = {
    id,
    clientId: newAccount.value.clientId,
    accountNumber: `ACC${Math.floor(100000 + Math.random() * 900000)}`,
    mainPackage: mainPackage,
    additionalPackages: additionalPackages,
    monthlyPaymentDay: newAccount.value.monthlyPaymentDay,
    status: "Active",
    createdDate: new Date().toISOString().split("T")[0],
    totalMonthlyFee,
    totalCoverageAmount,
    lastPaymentDate: new Date().toISOString().split("T")[0],
    nextPaymentDate: new Date(new Date().setDate(new Date().getDate() + 30))
      .toISOString()
      .split("T")[0],
  };

  accounts.value.push(newAccountData);
  newAccount.value = {
    clientId: "",
    mainPackageId: "",
    additionalPackageIds: [],
    monthlyPaymentDay: 1,
  };
  showAddAccountDialog.value = false;
};

const handleDeleteAccount = (accountId) => {
  accounts.value = accounts.value.filter((account) => account.id !== accountId);
  selectedAccount.value = null;
};
</script>
