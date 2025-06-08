<template>
  <div class="space-y-6">
    <!-- Header and Stats -->
    <div
      class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4"
    >
      <div>
        <h2 class="text-2xl font-bold">Client Management</h2>
        <p class="text-gray-600">Manage client registrations and information</p>
      </div>
      <AddButton @click="showDialog = true"> Add Client </AddButton>
    </div>

    <!-- Client Statistics -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
      <div class="bg-white rounded-lg shadow p-6">
        <h3 class="text-lg font-semibold">Total Clients</h3>
        <div class="mt-2">
          <div class="text-3xl font-bold">{{ clients.length }}</div>
          <p class="text-sm text-gray-600">Registered clients</p>
        </div>
      </div>
      <div class="bg-white rounded-lg shadow p-6">
        <h3 class="text-lg font-semibold">Active Clients</h3>
        <div class="mt-2">
          <div class="text-3xl font-bold">{{ activeClientsCount }}</div>
          <p class="text-sm text-gray-600">Currently active</p>
        </div>
      </div>
      <div class="bg-white rounded-lg shadow p-6">
        <h3 class="text-lg font-semibold">New This Month</h3>
        <div class="mt-2">
          <div class="text-3xl font-bold">{{ newClientsThisMonth }}</div>
          <p class="text-sm text-gray-600">Recent signups</p>
        </div>
      </div>
    </div>

    <!-- Search Box -->
    <SearchBox
      v-model="searchTerm"
      placeholder="Search clients by name, email, or ID..."
    />

    <!-- Clients Table -->
    <div class="bg-white rounded-lg shadow">
      <div class="p-6 border-b">
        <h3 class="text-lg font-semibold">
          Registered Clients ({{ filteredClients.length }})
        </h3>
        <p class="text-sm text-gray-500">
          Complete list of all registered clients and their details
        </p>
      </div>
      <div class="p-6">
        <div class="overflow-x-auto">
          <ResponsiveTable
            :clients="filteredClients"
            @delete="handleDeleteClient"
            @edit="handleEditClient"
          />
        </div>
      </div>
    </div>

    <!-- Client Dialog -->
    <DialogModal
      :show="showDialog"
      :title="isEditing ? 'Edit Client' : 'Add New Client'"
      :description="
        isEditing
          ? 'Update client information.'
          : 'Enter client information to register them in the system.'
      "
      :submit-text="isEditing ? 'Update' : 'Submit'"
      @cancel="resetForm"
      @submit="handleAddClient"
    >
      <template #form>
        <ClientForm
          :form="form"
          :statuses="statuses"
          :genders="genders"
          :titles="titles"
          :referralSources="referralSources"
        />
      </template>
    </DialogModal>
  </div>
</template>

<script setup>
import { ref, computed, onMounted } from "vue";
import ResponsiveTable from "@/Pages/Dashboard/Clients/ResponsiveTable.vue";
import ClientForm from "@/Pages/Dashboard/Clients/ClientForm.vue";
import SearchBox from "../Ui/SearchBox.vue";
import AddButton from "../Ui/AddButton.vue";
import DialogModal from "../Ui/DialogModal.vue";
import useCrud from "@/Composables/useCrud";

const props = defineProps({
  initialClients: {
    type: Array,
    default: () => [],
  },
  statuses: {
    type: Object,
    required: true,
  },
  genders: {
    type: Object,
    required: true,
  },
  referralSources: {
    type: Object,
    required: true,
  },
  titles: {
    type: Object,
    required: true,
  },
  activeClientsCount: {
    type: Number,
    default: 0,
  },
  newClientsThisMonth: {
    type: Number,
    default: 0,
  },
});

const searchTerm = ref("");
const clients = ref([...props.initialClients]);

const {
  form,
  isEditing,
  showDialog,
  loading,
  handleEdit: handleEditClient,
  handleSubmit: handleAddClient,
  handleDelete: handleDeleteClient,
  resetForm,
  setDefaults,
} = useCrud("clients", "client", clients, {
  title: "",
  firstname: "",
  middlename: "",
  surname: "",
  email: "",
  id_number: "",
  gender: "",
  phone: "",
  address: "",
  status: "active",
  notes: "",
  profile_picture: "",
  referral_source: "",
});

const filteredClients = computed(() => {
  const term = searchTerm.value.toLowerCase();
  if (!term) return clients.value;

  return clients.value.filter((client) => {
    const fullName = `${client.firstname} ${client.surname}`.toLowerCase();
    return (
      fullName.includes(term) ||
      (client.email && client.email.toLowerCase().includes(term)) ||
      (client.id_number && client.id_number.toLowerCase().includes(term)) ||
      (client.phone && client.phone.toLowerCase().includes(term))
    );
  });
});

// Optional: update defaults later
onMounted(() => {
  setDefaults({
    title: "",
    firstname: "",
    middlename: "",
    surname: "",
    email: "",
    id_number: "",
    gender: "",
    phone: "",
    address: "",
    status: "active",
    notes: "",
    profile_picture: "",
    referral_source: "",
  });
});
</script>
