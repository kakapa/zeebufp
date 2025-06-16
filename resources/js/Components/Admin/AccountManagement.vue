<template>
  <div class="space-y-6">
    <!-- Header and Stats -->
    <div
      class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4"
    >
      <div>
        <h2 class="text-2xl font-bold">Account Management</h2>
        <p class="text-gray-600">
          Manage client accounts and payment information
        </p>
      </div>
      <AddButton @click="showDialog = true"> Add Account </AddButton>
    </div>

    <!-- Account Statistics -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
      <StatsCard
        label="Total Accounts"
        icon="Clock"
        color="green"
        :value="accounts.length"
        description="Registered accounts"
      />

      <StatsCard
        label="Active Accounts"
        icon="Clock"
        color="red"
        :value="activeAccountsCount"
        description="Currently active"
      />

      <StatsCard
        label="Total Coverage"
        icon="DollarSign"
        color="indigo"
        :value="formatCurrency(totalCoverageAmount)"
        description="Across all accounts"
      />
    </div>

    <!-- Search Box -->
    <SearchBox
      v-model="searchTerm"
      placeholder="Search accounts by client, ID, or status..."
    />

    <!-- Accounts Table -->
    <div class="bg-white rounded-lg shadow">
      <div class="p-6 border-b">
        <h3 class="text-lg font-semibold">
          Registered Accounts ({{ filteredAccounts.length }})
        </h3>
        <p class="text-sm text-gray-500">
          Complete list of all accounts and their details
        </p>
      </div>
      <div class="p-6">
        <div class="overflow-x-auto">
          <ResponsiveTable
            :accounts="filteredAccounts"
            @delete="handleDeleteAccount"
            @edit="handleEditAccount"
          />
        </div>
      </div>
    </div>

    <!-- Account Dialog -->
    <DialogModal
      :show="showDialog"
      :title="isEditing ? 'Edit Account' : 'Create New Account'"
      :description="
        isEditing
          ? 'Update account information.'
          : 'Enter account details to register a new account.'
      "
      :submit-text="isEditing ? 'Update' : 'Submit'"
      @cancel="resetForm"
      @submit="handleAddAccount"
    >
      <template #form>
        <AccountForm
          :form="form"
          :statuses="statuses"
          :clients="clients"
          :packages="packages"
        />
      </template>
    </DialogModal>
  </div>
</template>

<script setup>
import { ref, computed, onMounted } from "vue";
import ResponsiveTable from "@/Pages/Dashboard/Accounts/ResponsiveTable.vue";
import AccountForm from "@/Pages/Dashboard/Accounts/AccountForm.vue";
import SearchBox from "../Ui/SearchBox.vue";
import AddButton from "../Ui/AddButton.vue";
import DialogModal from "../Ui/DialogModal.vue";
import useCrud from "@/Composables/useCrud";
import StatsCard from "../Ui/StatsCard.vue";

const props = defineProps({
  initialAccounts: {
    type: Array,
    default: () => [],
  },
  statuses: {
    type: Object,
    required: true,
  },
  clients: {
    type: Array,
    required: true,
  },
  packages: {
    type: Array,
    required: true,
  },
  activeAccountsCount: {
    type: Number,
    default: 0,
  },
  totalCoverageAmount: {
    type: Number,
    default: 0,
  },
});

const searchTerm = ref("");
const accounts = ref([...props.initialAccounts]);

const {
  form,
  isEditing,
  showDialog,
  handleEdit: handleEditAccount,
  handleSubmit: handleAddAccount,
  handleDelete: handleDeleteAccount,
  resetForm,
  setDefaults,
} = useCrud("accounts", "account", accounts, {
  client_id: "",
  package_id: "",
  payday: 1,
  status: "active",
  total_coverage_amount: 0,
  last_payment_at: "",
  next_payment_at: "",
});

const filteredAccounts = computed(() => {
  const term = searchTerm.value.toLowerCase();
  if (!term) return accounts.value;

  return accounts.value.filter((account) => {
    const client = props.clients.find((c) => c.id === account.client_id);
    const clientName = client
      ? `${client.firstname} ${client.surname}`.toLowerCase()
      : "";
    const accountId = account.slug ? account.slug.toLowerCase() : "";

    return (
      clientName.includes(term) ||
      accountId.includes(term) ||
      account.status.toLowerCase().includes(term)
    );
  });
});

const formatCurrency = (value) => {
  return new Intl.NumberFormat("en-ZA", {
    style: "currency",
    currency: "ZAR",
  }).format(value);
};

onMounted(() => {
  setDefaults({
    client_id: "",
    package_id: "",
    payday: 1,
    status: "active",
    total_coverage_amount: 0,
    last_payment_at: "",
    next_payment_at: "",
  });
});
</script>
