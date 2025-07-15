<template>
  <div class="space-y-6">
    <!-- Header and Stats -->
    <div
      class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4"
    >
      <div>
        <h2 class="text-2xl font-bold">Contribution Management</h2>
        <p class="text-gray-600">
          Manage client contributions and payment records
        </p>
      </div>
      <AddButton @click="showDialog = true"> Add Contribution </AddButton>
    </div>

    <!-- Contribution Statistics -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
      <StatsCard
        label="Total Contributions"
        icon="DollarSign"
        color="green"
        :value="totalContributions"
        description="All-time total"
      />

      <StatsCard
        label="Pending"
        icon="ClockArrowUp"
        color="red"
        :value="pendingContributionsCount"
        description="Awaiting payment"
      />

      <StatsCard
        label="This Month"
        icon="ChartArea"
        color="blue"
        :value="monthlyContributions"
        description="Current month total"
      />

      <StatsCard
        label="Average"
        icon="ChartLine"
        color="indigo"
        :value="averageContribution"
        description="Per contribution"
      />
    </div>

    <!-- Filters -->
    <div
      class="bg-white rounded-lg shadow p-6 grid grid-cols-1 md:grid-cols-3 gap-4"
    >
      <div>
        <InputLabel for="status-filter" value="Status" />
        <Select
          id="status-filter"
          label="Status"
          v-model="filters.status"
          :items="statuses"
          show-default-option
          default-option-text="All Statuses"
        />
      </div>
      <div>
        <InputLabel for="date-range" value="Date Range" />
        <Select
          id="date-range"
          label="Date Range"
          v-model="filters.dateRange"
          :items="dateRangeOptions"
        />
      </div>
      <div>
        <InputLabel for="account-filter" value="Account" />
        <SearchableSelect
          id="account-filter"
          label="Account"
          v-model="filters.accountId"
          :items="accounts"
          item-key="id"
          item-value="slug"
          searchable
          show-default-option
          default-option-text="All Accounts"
        />
      </div>
    </div>

    <!-- Search Box -->
    <SearchBox
      v-model="searchTerm"
      placeholder="Search contributions by reference, account, or amount..."
    />

    <!-- Contributions Table -->
    <div class="bg-white rounded-lg shadow">
      <div class="p-6 border-b">
        <h3 class="text-lg font-semibold">
          Contribution Records ({{ filteredContributions.length }})
        </h3>
        <p class="text-sm text-gray-500">
          List of all contribution payments and their details
        </p>
      </div>
      <div class="p-6">
        <div class="overflow-x-auto">
          <ResponsiveTable
            :contributions="filteredContributions"
            @delete="handleDeleteContribution"
            @edit="handleEditContribution"
            @mark-paid="handleMarkAsPaid"
          />
        </div>
      </div>
    </div>

    <!-- Contribution Dialog -->
    <DialogModal
      :show="showDialog"
      :title="isEditing ? 'Edit Contribution' : 'Record New Contribution'"
      :description="
        isEditing
          ? 'Update contribution details.'
          : 'Enter contribution payment information.'
      "
      :submit-text="isEditing ? 'Update' : 'Submit'"
      @cancel="resetForm"
      @submit="handleSubmitContribution"
    >
      <template #form>
        <ContributionForm
          :form="form"
          :accounts="accounts"
          :statuses="statuses"
          :method-options="methodOptions"
          :type-options="typeOptions"
        />
      </template>
    </DialogModal>
  </div>
</template>

<script setup>
import { ref, computed, onMounted } from "vue";
import { router } from "@inertiajs/vue3";
import ResponsiveTable from "@/Pages/Dashboard/Contributions/ResponsiveTable.vue";
import ContributionForm from "@/Pages/Dashboard/Contributions/ContributionForm.vue";
import SearchBox from "../Ui/SearchBox.vue";
import AddButton from "../Ui/AddButton.vue";
import DialogModal from "../Ui/DialogModal.vue";
import Select from "../Ui/Select.vue";
import SearchableSelect from "../Ui/SearchableSelect.vue";
import InputLabel from "../Ui/InputLabel.vue";
import useCrud from "@/Composables/useCrud";
import StatsCard from "../Ui/StatsCard.vue";

const props = defineProps({
  initialContributions: {
    type: Array,
    default: () => [],
  },
  accounts: {
    type: Array,
    default: () => [],
  },
  statuses: {
    type: Object,
    required: true,
  },
  methodOptions: {
    type: Object,
    required: true,
  },
  typeOptions: {
    type: Object,
    required: true,
  },
  stats: {
    type: Object,
    default: {
      total: 0,
      pending: 0,
      average: 0,
      monthly: 0,
    },
  },
});

const searchTerm = ref("");
const filters = ref({
  status: "",
  dateRange: "this_month",
  accountId: "",
});
const contributions = ref([...props.initialContributions]);

const {
  form,
  isEditing,
  showDialog,
  loading,
  handleEdit: handleEditContribution,
  handleSubmit: handleSubmitContribution,
  handleDelete: handleDeleteContribution,
  resetForm,
  setDefaults,
} = useCrud("payments", "payment", contributions, {
  account_id: null,
  claim_id: null,
  amount: 0,
  status: "pending",
  type: "contribution",
  method: "eft",
  reference: "",
  notes: "",
});

// Statistics
const totalContributions = computed(() => props.stats.total || 0);
const pendingContributionsCount = computed(() => props.stats.pending || 0);
const monthlyContributions = computed(() => props.stats.monthly || 0);
const averageContribution = computed(() => props.stats.average || 0);

// Date range options
const dateRangeOptions = ref({
  all: "All Time",
  today: "Today",
  this_week: "This Week",
  this_month: "This Month",
  last_month: "Last Month",
  this_year: "This Year",
});

// Filter contributions
const filteredContributions = computed(() => {
  let results = contributions.value;
  const term = searchTerm.value.toLowerCase();
  const { status, dateRange, accountId } = filters.value;

  // Apply status filter
  if (status) {
    results = results.filter((c) => c.status === status);
  }

  // Apply account filter
  if (accountId) {
    results = results.filter((c) => c.account_id === accountId);
  }

  // Apply date range filter
  if (dateRange) {
    const now = new Date();
    let startDate;

    switch (dateRange) {
      case "today":
        startDate = new Date(now.setHours(0, 0, 0, 0));
        break;
      case "this_week":
        startDate = new Date(now.setDate(now.getDate() - now.getDay()));
        break;
      case "this_month":
        startDate = new Date(now.getFullYear(), now.getMonth(), 1);
        break;
      case "last_month":
        startDate = new Date(now.getFullYear(), now.getMonth() - 1, 1);
        const endDate = new Date(now.getFullYear(), now.getMonth(), 0);
        results = results.filter((c) => {
          const payDate = new Date(c.created_at);
          return payDate >= startDate && payDate <= endDate;
        });
        break;
      case "this_year":
        startDate = new Date(now.getFullYear(), 0, 1);
        break;
      default:
        // 'all' or unknown - no date filtering
        break;
    }

    if (dateRange !== "last_month" && dateRange !== "all") {
      results = results.filter((c) => new Date(c.created_at) >= startDate);
    }
  }

  // Apply search term
  if (term) {
    results = results.filter((c) => {
      return (
        (c.reference && c.reference.toLowerCase().includes(term)) ||
        (c.amount && c.amount.toString().includes(term)) ||
        (findAccountName(c.account_id) &&
          findAccountName(c.account_id).toLowerCase().includes(term))
      );
    });
  }

  return results;
});

// Helper to find account name
const findAccountName = (accountId) => {
  const account = props.accounts.find((a) => a.id === accountId);
  return account
    ? `${account.client.firstname} ${account.client.lastname}`
    : "";
};

// Format currency
const formatCurrency = (amount) => {
  return new Intl.NumberFormat("en-ZA", {
    style: "currency",
    currency: "ZAR",
  }).format(amount);
};

// Mark as paid action
const handleMarkAsPaid = (contributionId) => {
  if (confirm("Mark this contribution as paid?")) {
    router.put(route("contributions.mark-paid", contributionId), {
      onSuccess: () => {
        const index = contributions.value.findIndex(
          (c) => c.id === contributionId
        );
        if (index !== -1) {
          contributions.value[index].status = "paid";
          contributions.value[index].paid_at = new Date().toISOString();
        }
      },
    });
  }
};

// Set form defaults
onMounted(() => {
  setDefaults({
    account_id: null,
    claim_id: null,
    amount: 0,
    status: "pending",
    type: "contribution",
    method: "eft",
    reference: "",
    notes: "",
  });
});
</script>
