<template>
  <AuthenticatedLayout>
    <Head title="Funeral Parlour Admin Dashboard" />

    <div class="container mx-auto px-4 py-8">
      <!-- Quick Stats -->
      <QuickStats :stats="stats" />

      <!-- Main Dashboard -->
      <div class="space-y-4">
        <div class="flex w-full bg-white rounded-lg shadow overflow-hidden">
          <button
            v-for="tab in tabs"
            :key="tab.value"
            @click="activeTab = tab.value"
            :class="[
              'flex-1 py-3 px-4 text-sm font-medium flex items-center justify-center gap-2',
              activeTab === tab.value
                ? 'bg-secondary-50 text-secondary-700 border-b-2 border-secondary-700'
                : 'text-gray-600 hover:text-gray-800 hover:bg-gray-50',
            ]"
          >
            <component :is="tab.icon" class="h-4 w-4 flex-shrink-0" />
            <span class="hidden sm:inline text-xs sm:text-sm">{{
              tab.label
            }}</span>
          </button>
        </div>

        <div v-if="activeTab === 'dashboard'" class="space-y-4">
          <Dashboard />
        </div>

        <div v-if="activeTab === 'clients'" class="space-y-4">
          <ClientManagement
            :initial-clients="clients"
            :statuses="client_statuses"
            :genders="genders"
            :referralSources="sources"
            :titles="titles"
          />
        </div>

        <div v-if="activeTab === 'accounts'" class="space-y-4">
          <AccountManagement
            :initial-accounts="accounts"
            :statuses="account_statuses"
            :packages="packages"
            :clients="clients"
          />
        </div>

        <div v-if="activeTab === 'packages'" class="space-y-4">
          <PackageManagement
            :packages="packages"
            :statuses="package_statuses"
          />
        </div>

        <div v-if="activeTab === 'contributions'" class="space-y-4">
          <ContributionsTracking
            :initial-contributions="contributions"
            :accounts="accounts"
            :statuses="payment_statuses"
            :method-options="payment_methods"
            :type-options="payment_types"
          />
        </div>

        <div v-if="activeTab === 'claims'" class="space-y-4">
          <ClaimsProcessing
            :initial-claims="claims"
            :clients="clients"
            :statuses="claim_statuses"
            :type-options="claim_types"
          />
        </div>
      </div>
    </div>
  </AuthenticatedLayout>
</template>

<script setup>
import { ref } from "vue";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import ClientManagement from "@/Components/Admin/ClientManagement.vue";
import PackageManagement from "@/Components/Admin/PackageManagement.vue";
import ContributionsTracking from "@/Components/Admin/ContributionsTracking.vue";
import AccountManagement from "@/Components/Admin/AccountManagement.vue";
import ClaimsProcessing from "@/Components/Admin/ClaimsProcessing.vue";
import Dashboard from "@/Components/Admin/Dashboard.vue";
import QuickStats from "./Dashboard/QuickStats.vue";
import {
  Users,
  Package,
  DollarSign,
  FileText,
  BarChart3,
  FileSliders,
} from "lucide-vue-next";

const props = defineProps({
  packages: Array,
  clients: Array,
  accounts: Array,
  contributions: Array,
  claims: Array,
  package_statuses: Object,
  client_statuses: Object,
  client_statuses: Object,
  account_statuses: Object,
  payment_statuses: Object,
  payment_methods: Object,
  payment_types: Object,
  claim_statuses: Object,
  claim_types: Object,
  sources: Object,
  genders: Object,
  titles: Object,
  activeAccountsCount: Number,
  pendingClaimsCount: Number,
  monthlyContributionsSum: String,
});

const activeTab = ref("dashboard");

const stats = [
  {
    title: "Total Clients",
    value: props.clients.length,
    icon: Users,
    change: "+12%",
  },
  {
    title: "Active Accounts",
    value: props.activeAccountsCount,
    icon: Package,
    change: "+5%",
  },
  {
    title: "Monthly Contributions",
    value: props.monthlyContributionsSum,
    icon: DollarSign,
    change: "+18%",
  },
  {
    title: "Pending Claims",
    value: props.pendingClaimsCount,
    icon: FileText,
    change: "-3%",
  },
];

const tabs = [
  { value: "dashboard", label: "Dashboard", icon: BarChart3 },
  { value: "clients", label: "Clients", icon: Users },
  { value: "accounts", label: "Accounts", icon: FileSliders },
  { value: "packages", label: "Packages", icon: Package },
  { value: "contributions", label: "Contributions", icon: DollarSign },
  { value: "claims", label: "Claims", icon: FileText },
];
</script>
