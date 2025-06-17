<template>
  <div class="space-y-6">
    <!-- Header and Stats -->
    <div
      class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4"
    >
      <div>
        <h2 class="text-2xl font-bold">Claims Management</h2>
        <p class="text-gray-600">Manage client claims and processing</p>
      </div>
      <AddButton @click="showDialog = true"> Add Claim </AddButton>
    </div>

    <!-- Claim Statistics -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
      <StatsCard
        label="Total Claims"
        icon="Clock"
        color="green"
        :value="claims.length"
        description="All claims"
      />

      <StatsCard
        label="Pending"
        icon="Clock"
        color="green"
        :value="pendingClaimsCount"
        description="Awaiting processing"
      />

      <StatsCard
        label="This Month"
        icon="Clock"
        color="green"
        :value="monthlyClaimsCount"
        description="Current month"
      />

      <StatsCard
        label="Total Value"
        icon="Clock"
        color="green"
        :value="totalClaimsValue"
        description="All claims amount"
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
        <InputLabel for="type-filter" value="Type" />
        <Select
          id="type-filter"
          label="Type"
          v-model="filters.type"
          :items="typeOptions"
          show-default-option
          default-option-text="All Types"
        />
      </div>
      <div>
        <InputLabel for="client-filter" value="Client" />
        <SearchableSelect
          id="client-filter"
          label="Client"
          v-model="filters.clientId"
          :items="clients"
          item-key="id"
          :item-value="(client) => `${client.firstname} ${client.lastname}`"
          searchable
          show-default-option
          default-option-text="All Clients"
        />
      </div>
    </div>

    <!-- Search Box -->
    <SearchBox
      v-model="searchTerm"
      placeholder="Search claims by reference, client, or amount..."
    />

    <!-- Claims Table -->
    <div class="bg-white rounded-lg shadow">
      <div class="p-6 border-b">
        <h3 class="text-lg font-semibold">
          Claim Records ({{ filteredClaims.length }})
        </h3>
        <p class="text-sm text-gray-500">
          List of all claims and their processing status
        </p>
      </div>
      <div class="p-6">
        <div class="overflow-x-auto">
          <ResponsiveTable
            :claims="filteredClaims"
            @delete="handleDeleteClaim"
            @edit="handleEditClaim"
            @assign="handleAssignClaim"
          />
        </div>
      </div>
    </div>

    <!-- Claim Dialog -->
    <DialogModal
      :show="showDialog"
      :title="isEditing ? 'Edit Claim' : 'Create New Claim'"
      :description="
        isEditing
          ? 'Update claim details.'
          : 'Enter claim information for processing.'
      "
      :submit-text="isEditing ? 'Update' : 'Submit'"
      @cancel="resetForm"
      @submit="handleSubmitClaim"
    >
      <template #form>
        <ClaimForm
          :form="form"
          :clients="clients"
          :statuses="statuses"
          :type-options="typeOptions"
        />
      </template>
    </DialogModal>
  </div>
</template>

<script setup>
import { ref, computed, onMounted } from "vue";
import { router } from "@inertiajs/vue3";
import ResponsiveTable from "@/Pages/Dashboard/Claims/ResponsiveTable.vue";
import ClaimForm from "@/Pages/Dashboard/Claims/ClaimForm.vue";
import SearchBox from "../Ui/SearchBox.vue";
import AddButton from "../Ui/AddButton.vue";
import DialogModal from "../Ui/DialogModal.vue";
import Select from "../Ui/Select.vue";
import SearchableSelect from "../Ui/SearchableSelect.vue";
import InputLabel from "../Ui/InputLabel.vue";
import useCrud from "@/Composables/useCrud";
import StatsCard from "../Ui/StatsCard.vue";

const props = defineProps({
  initialClaims: {
    type: Array,
    default: () => [],
  },
  clients: {
    type: Array,
    required: true,
  },
  statuses: {
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
      pending: 0,
      total_value: 0,
      monthly: 0,
    },
  },
});

const searchTerm = ref("");
const filters = ref({
  status: "",
  type: "",
  clientId: "",
});
const claims = ref([...props.initialClaims]);

const {
  form,
  isEditing,
  showDialog,
  loading,
  handleEdit: handleEditClaim,
  handleSubmit: handleSubmitClaim,
  handleDelete: handleDeleteClaim,
  resetForm,
  setDefaults,
} = useCrud("claims", "claim", claims, {
  client_id: null,
  amount: 0,
  status: "submitted",
  type: "funeral",
  description: "",
  submission_at: new Date().toISOString().split("T")[0],
});

// Statistics
const pendingClaimsCount = computed(() => props.stats.pending || 0);
const monthlyClaimsCount = computed(() => props.stats.monthly || 0);
const totalClaimsValue = computed(() => props.stats.total_value || 0);

// Filter claims
const filteredClaims = computed(() => {
  let results = claims.value;
  const term = searchTerm.value.toLowerCase();
  const { status, type, clientId } = filters.value;

  // Apply status filter
  if (status) {
    results = results.filter((c) => c.status === status);
  }

  // Apply type filter
  if (type) {
    results = results.filter((c) => c.type === type);
  }

  // Apply client filter
  if (clientId) {
    results = results.filter((c) => c.client_id === clientId);
  }

  // Apply search term
  if (term) {
    results = results.filter((c) => {
      return (
        (c.slug && c.slug.toLowerCase().includes(term)) ||
        (c.amount && c.amount.toString().includes(term)) ||
        (findClientName(c.client_id) &&
          findClientName(c.client_id).toLowerCase().includes(term))
      );
    });
  }

  return results;
});

// Helper to find client name
const findClientName = (clientId) => {
  const client = props.clients.find((c) => c.id === clientId);
  return client ? `${client.firstname} ${client.lastname}` : "";
};

// Format currency
const formatCurrency = (amount) => {
  return new Intl.NumberFormat("en-ZA", {
    style: "currency",
    currency: "ZAR",
  }).format(amount);
};

// Assign claim to user
const handleAssignClaim = (claimId, userId) => {
  router.put(route("claims.assign", claimId), {
    user_id: userId,
    onSuccess: () => {
      const index = claims.value.findIndex((c) => c.id === claimId);
      if (index !== -1) {
        claims.value[index].user_id = userId;
      }
    },
  });
};

// Set form defaults
onMounted(() => {
  setDefaults({
    client_id: null,
    amount: 0,
    status: "submitted",
    type: "funeral",
    description: "",
    submission_at: new Date().toISOString().split("T")[0],
  });
});
</script>
