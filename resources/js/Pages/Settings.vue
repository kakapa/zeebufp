<template>
  <AuthenticatedLayout>
    <Head title="Settings" />

    <div class="container mx-auto px-4 py-8 space-y-6">
      <!-- Header and Stats -->
      <div
        class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4"
      >
        <div>
          <h2 class="text-2xl font-bold">Settings</h2>
          <p class="text-gray-600">
            Manage personal information, system preferences, and credentials.
          </p>
        </div>
      </div>

      <div class="container mx-auto">
        <div class="grid grid-cols-1 lg:grid-cols-4 gap-6">
          <!-- Sidebar Navigation -->
          <div class="lg:col-span-1">
            <div class="bg-white rounded-lg shadow overflow-hidden">
              <ul class="divide-y divide-gray-200">
                <li v-for="tab in tabs" :key="tab.id">
                  <button
                    @click="activeTab = tab.id"
                    class="w-full px-4 py-3 text-left text-sm font-medium"
                    :class="{
                      'bg-secondary-50 text-secondary-700':
                        activeTab === tab.id,
                      'text-gray-700 hover:bg-gray-50': activeTab !== tab.id,
                    }"
                  >
                    <div class="flex items-center space-x-3">
                      <component :is="tab.icon" class="h-5 w-5" />
                      <span>{{ tab.label }}</span>
                    </div>
                  </button>
                </li>
              </ul>
            </div>
          </div>

          <!-- Main Content -->
          <div class="lg:col-span-3 space-y-6">
            <!-- Profile Settings -->
            <UpdateProfileInformationForm
              :status="status"
              :countries="countries"
              :activeTab="activeTab"
              :occupations="occupations"
              :genderItems="genderItems"
              :workStatusItems="workStatusItems"
              :must-verify-email="mustVerifyEmail"
              :educationLevelItems="educationLevelItems"
            />

            <!-- Security Settings -->
            <UpdatePasswordForm :activeTab="activeTab" />

            <!-- System Settings -->
            <UserSystemSettings :activeTab="activeTab" />
          </div>
        </div>
      </div>
    </div>
  </AuthenticatedLayout>
</template>

<script setup>
import { ref } from "vue";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { User, Lock, Settings as SettingsIcon } from "lucide-vue-next";
import UpdatePasswordForm from "./Profile/Partials/UpdatePasswordForm.vue";
import UserSystemSettings from "./Profile/Partials/UserSystemSettings.vue";
import UpdateProfileInformationForm from "./Profile/Partials/UpdateProfileInformationForm.vue";

const activeTab = ref("profile");

const tabs = [
  { id: "profile", label: "Profile", icon: User },
  { id: "security", label: "Security", icon: Lock },
  { id: "system", label: "System", icon: SettingsIcon },
];

defineProps({
  mustVerifyEmail: {
    type: Boolean,
  },
  status: {
    type: String,
  },
  countries: {
    type: Object,
  },
  genderItems: {
    type: Object,
  },
  maritalStatusItems: {
    type: Object,
  },
  workStatusItems: {
    type: Object,
  },
  educationLevelItems: {
    type: Object,
  },
  sourceItems: {
    type: Object,
  },
  occupations: {
    type: Object,
  },
});
</script>
