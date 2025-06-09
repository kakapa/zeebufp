<template>
  <AuthenticatedLayout>
    <Head title="Funeral Parlour Admin Dashboard" />

    <div class="container mx-auto px-4 py-8">
      <!-- Quick Stats -->
      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <div
          v-for="(stat, index) in stats"
          :key="index"
          class="bg-white rounded-lg shadow p-6"
        >
          <div class="flex items-center justify-between pb-2">
            <h3 class="text-sm font-medium text-gray-600">
              {{ stat.title }}
            </h3>
            <component :is="stat.icon" class="h-4 w-4 text-gray-400" />
          </div>
          <div>
            <div class="text-2xl font-bold">{{ stat.value }}</div>
            <p class="text-xs text-gray-500">
              <span
                :class="
                  stat.change.startsWith('+')
                    ? 'text-green-600'
                    : 'text-red-600'
                "
              >
                {{ stat.change }}
              </span>
              from last month
            </p>
          </div>
        </div>
      </div>

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
                ? 'bg-blue-50 text-blue-700 border-b-2 border-blue-700'
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
});

const activeTab = ref("dashboard");

const stats = [
  { title: "Total Clients", value: "1,248", icon: Users, change: "+12%" },
  { title: "Active Packages", value: "842", icon: Package, change: "+5%" },
  {
    title: "Monthly Contributions",
    value: "$45,230",
    icon: DollarSign,
    change: "+18%",
  },
  { title: "Pending Claims", value: "23", icon: FileText, change: "-3%" },
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
