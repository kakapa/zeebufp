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
        icon="FolderTree"
        color="blue"
        :value="accounts.length"
        description="Registered accounts"
      />

      <StatsCard
        label="Active Accounts"
        icon="FileKey2"
        color="indigo"
        :value="activeAccountsCount"
        description="Currently active"
      />

      <StatsCard
        label="Total Coverage"
        icon="DollarSign"
        color="green"
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
            @create-beneficiary="handleCreateBeneficiary"
            @add-additional-package="handleAddAdditionalPackage"
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

    <!-- Beneficiary Dialog -->
    <DialogModal
      :show="showBeneficiaryDialog"
      title="Add Beneficiary"
      description="Enter beneficiary details for this account"
      submit-text="Add Beneficiary"
      :processing="beneficiaryForm.processing"
      @cancel="resetBeneficiaryForm"
      @submit="submitBeneficiary"
    >
      <template #form>
        <BeneficiaryForm
          :beneficiary-form="beneficiaryForm"
          :selected-account="selectedAccount"
          :genders="genders"
          :relationships="relationships"
        />
      </template>
    </DialogModal>

    <!-- Add Package Dialog -->
    <DialogModal
      :show="showAddPackageDialog"
      title="Add Additional Package"
      description="Select additional packages to add to this account"
      submit-text="Add Packages"
      :processing="packageForm.processing"
      @cancel="resetPackageForm"
      @submit="submitAdditionalPackages"
    >
      <template #form>
        <AdditionalPackagesForm
          :selected-account-for-package="selectedAccountForPackage"
          :package-form="packageForm"
          :addtional-packages="addtionalPackages"
        />
      </template>
    </DialogModal>
  </div>
</template>

<script setup>
import { ref, computed, onMounted } from "vue";
import { useForm } from "@inertiajs/vue3";
import SearchBox from "../Ui/SearchBox.vue";
import AddButton from "../Ui/AddButton.vue";
import DialogModal from "../Ui/DialogModal.vue";
import useCrud from "@/Composables/useCrud";
import StatsCard from "../Ui/StatsCard.vue";
import { useToast } from "vue-toast-notification";
import ResponsiveTable from "@/Pages/Dashboard/Accounts/ResponsiveTable.vue";
import AccountForm from "@/Pages/Dashboard/Accounts/AccountForm.vue";
import BeneficiaryForm from "@/Pages/Dashboard/Accounts/BeneficiaryForm.vue";
import AdditionalPackagesForm from "@/Pages/Dashboard/Accounts/AdditionalPackagesForm.vue";

const props = defineProps({
  initialAccounts: {
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
  relationships: {
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
  allAdditionalPackages: {
    type: Array,
    default: [],
  },
  activeAccountsCount: {
    type: Number,
    default: 0,
  },
  totalCoverageAmount: {
    type: Number,
    default: 0,
  },
  beneficiary: {
    type: Object,
    default: () => ({}),
  },
});

const searchTerm = ref("");
const accounts = ref([...props.initialAccounts]);
const showBeneficiaryDialog = ref(false);
const selectedAccount = ref(null);
const toast = useToast();

// Initialize beneficiary form with useForm
const beneficiaryForm = useForm({
  account_id: null,
  firstname: "",
  middlename: "",
  lastname: "",
  relationship: "spouse",
  gender: "female",
  id_number: "",
  phone: "",
});

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
  status: "pending",
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
      ? `${client.firstname} ${client.lastname}`.toLowerCase()
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

const handleCreateBeneficiary = (account) => {
  selectedAccount.value = account;
  beneficiaryForm.reset();
  beneficiaryForm.account_id = account.id;
  showBeneficiaryDialog.value = true;
};

const resetBeneficiaryForm = () => {
  showBeneficiaryDialog.value = false;
  selectedAccount.value = null;
  beneficiaryForm.reset();
};

const submitBeneficiary = () => {
  beneficiaryForm.post(route("beneficiaries.store"), {
    preserveScroll: true,
    onSuccess: () => {
      // Find the account in the accounts array and update it
      const accountIndex = accounts.value.findIndex(
        (acc) => acc.slug === beneficiaryForm.account_id
      );
      console.log("Account Index:", accountIndex);
      if (accountIndex !== -1) {
        accounts.value[accountIndex].beneficiaries.push(props.beneficiary);
      }
      resetBeneficiaryForm();
      toast.success("Beneficiary added successfully", {
        position: "top-right",
      });
    },
    onError: () => {
      toast.error("Failed to add beneficiary", {
        position: "top-right",
      });
    },
  });
};

// Add these to your existing script setup
const showAddPackageDialog = ref(false);
const selectedAccountForPackage = ref(null);
const addtionalPackages = ref([...props.allAdditionalPackages]); // Assuming packages are passed as prop

const packageForm = useForm({
  account_id: null,
  selected_packages: [],
});

const handleAddAdditionalPackage = (account) => {
  selectedAccountForPackage.value = account;
  packageForm.reset();
  packageForm.account_id = account.id;

  // Filter out packages already associated with the account
  addtionalPackages.value = props.allAdditionalPackages.filter(
    (pkg) =>
      !account.additionalPackages.some((accountPkg) => accountPkg.id === pkg.id)
  );

  showAddPackageDialog.value = true;
};

const resetPackageForm = () => {
  showAddPackageDialog.value = false;
  selectedAccountForPackage.value = null;
  packageForm.reset();
};

const submitAdditionalPackages = () => {
  packageForm.post(
    route("accounts.packages.attach", {
      account: packageForm.account_id,
    }),
    {
      preserveScroll: true,
      onSuccess: () => {
        resetPackageForm();
        // Refresh account data or show success notification
        toast.success("Additional packages added successfully");
      },
      onError: () => {
        toast.error("Failed to add packages");
      },
    }
  );
};

onMounted(() => {
  setDefaults({
    client_id: "",
    package_id: "",
    payday: 1,
    status: "pending",
    total_coverage_amount: 0,
    last_payment_at: "",
    next_payment_at: "",
  });
});
</script>
