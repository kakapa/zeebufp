<template>
  <div class="space-y-6">
    <!-- Header -->
    <div
      class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4"
    >
      <div>
        <h2 class="text-2xl font-bold">Package Management</h2>
        <p class="text-gray-600">Manage funeral packages and pricing</p>
      </div>
      <AddButton v-if="authUser.isAdmin" @click="showDialog = true">
        Add Package
      </AddButton>
    </div>

    <!-- Package Statistics -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
      <StatsCard
        label="Total Packages"
        icon="Boxes"
        color="indigo"
        :value="packages.length"
        description="Active packages"
      />

      <StatsCard
        label="Total Subscribers"
        icon="BookUser"
        color="red"
        :value="totalSubscribers"
        description="Across all packages"
      />

      <StatsCard
        label="Monthly Revenue"
        icon="ChartNoAxesCombined"
        color="green"
        :value="monthlyRevenue"
        description="Expected monthly"
      />
    </div>

    <!-- Packages Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-2 xl:grid-cols-3 gap-6">
      <div
        v-for="pkg in packages"
        :key="pkg.id"
        class="bg-white rounded-lg shadow relative"
      >
        <!-- If pkg.main (main package) add ribbon on top right -->
        <div
          v-if="pkg.main"
          class="absolute -top-2 -right-2 bg-indigo-600 text-white text-xs font-bold px-3 py-1 rounded-md shadow-lg z-10"
        >
          <ShieldCheck class="inline-block h-5 w-5" />
        </div>
        <div class="p-6 border-b">
          <div class="flex items-center justify-between">
            <h3 class="text-xl font-semibold">{{ pkg.name }}</h3>
            <span
              :class="[
                'px-2 py-1 text-xs rounded-full',
                pkg.status === 'active'
                  ? 'bg-green-100 text-green-800'
                  : pkg.status === 'inactive'
                  ? 'bg-yellow-100 text-yellow-800'
                  : 'bg-red-100 text-red-800',
              ]"
            >
              {{ pkg.statusLabel }}
            </span>
          </div>
          <p class="text-sm text-gray-600 mt-1">{{ pkg.description }}</p>
        </div>

        <div class="p-6 space-y-4">
          <!-- Pricing -->
          <div class="text-center p-4 bg-gray-50 rounded-lg">
            <div class="text-3xl font-bold text-primary-600">
              {{ pkg.monthlyContributionString }}
            </div>
            <div class="text-sm text-gray-600">per month</div>
            <div class="text-lg font-semibold mt-2">
              {{ pkg.coverageAmountString }} coverage
            </div>
          </div>

          <!-- Subscribers -->
          <div
            class="flex items-center justify-between p-3 bg-secondary-50 rounded-lg"
          >
            <div class="flex items-center gap-2">
              <Users class="h-4 w-4 text-secondary-600" />
              <span class="text-sm font-medium">Subscribers</span>
            </div>
            <span class="text-lg font-bold text-secondary-600">{{
              pkg.subscribers
            }}</span>
          </div>

          <!-- Features -->
          <div>
            <h4 class="font-medium mb-2">Features Included:</h4>
            <ul class="space-y-1">
              <li
                v-for="(feature, index) in pkg.featuresArray"
                :key="index"
                class="text-sm text-gray-600 flex items-center gap-2"
              >
                <div class="w-1.5 h-1.5 bg-primary-600 rounded-full"></div>
                {{ feature }}
              </li>
            </ul>
          </div>

          <!-- Actions -->
          <div class="flex gap-2 pt-4" v-if="authUser.isAdmin">
            <button
              class="flex-1 px-4 py-2 border border-gray-300 rounded-md hover:bg-gray-50 flex items-center justify-center"
              @click="handleEditPackage(pkg)"
            >
              <Edit class="h-4 w-4" />
            </button>
            <button
              v-if="shouldShowPackage(pkg)"
              class="flex-1 px-4 py-2 border border-red-300 rounded-md hover:bg-gray-50 flex items-center justify-center"
              @click="handleDeletePackage(pkg)"
            >
              <Trash2 class="h-4 w-4" />
            </button>
          </div>
        </div>
      </div>
    </div>

    <!-- New Package Dialog -->
    <DialogModal
      :show="showDialog"
      :title="isEditing ? 'Edit Package' : 'Add New Package'"
      :description="
        isEditing
          ? 'Update package information.'
          : 'Enter package information to store it in the system.'
      "
      :submit-text="isEditing ? 'Update' : 'Submit'"
      @cancel="resetForm"
      @submit="handleAddPackage"
    >
      <template #form>
        <PackageForm :form="form" :statuses="statuses" />
      </template>
    </DialogModal>
  </div>
</template>

<script setup>
import { ref, onMounted } from "vue";
import { Edit, Users, Trash2, ShieldCheck } from "lucide-vue-next";
import AddButton from "../Ui/AddButton.vue";
import DialogModal from "../Ui/DialogModal.vue";
import PackageForm from "@/Pages/Dashboard/Packages/PackageForm.vue";
import useCrud from "@/Composables/useCrud";
import StatsCard from "../Ui/StatsCard.vue";
import { usePage } from "@inertiajs/vue3";

const props = defineProps({
  packages: {
    type: Array,
    default: () => [],
  },
  statuses: {
    type: Object,
    required: true,
  },
  totalSubscribers: {
    type: String,
    default: "0",
  },
  monthlyRevenue: {
    type: String,
    default: "0",
  },
});

const packages = ref([...props.packages]);
const authUser = usePage().props.auth.user;

const {
  form,
  isEditing,
  showDialog,
  loading,
  handleEdit: handleEditPackage,
  handleSubmit: handleAddPackage,
  handleDelete: handleDeletePackage,
  resetForm,
  setDefaults,
} = useCrud("packages", "package", packages, {
  name: "",
  description: "",
  contribution: 0,
  coverage: 0,
  features: "",
  main: false,
  status: "inactive",
});

// Optional: update defaults later
onMounted(() => {
  setDefaults({
    name: "",
    description: "",
    contribution: 0,
    coverage: 0,
    features: "",
    main: false,
    status: "inactive",
  });
});

const shouldShowPackage = (pkg) => {
  // Explicit checks for all falsey cases
  const isNotMain =
    pkg.main === false ||
    pkg.main === 0 ||
    pkg.main === "false" ||
    pkg.main === null ||
    pkg.main === undefined;

  return isNotMain || pkg.subscribers === 0;
};
</script>
