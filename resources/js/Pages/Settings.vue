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
            <div
              v-if="activeTab === 'security'"
              class="bg-white rounded-lg shadow overflow-hidden"
            >
              <div class="p-6 border-b">
                <h2 class="text-lg font-semibold">Security Settings</h2>
                <p class="text-sm text-gray-500">
                  Update your password and enable two-factor authentication.
                </p>
              </div>
              <div class="p-6 space-y-6">
                <div>
                  <h3 class="font-medium mb-4">Change Password</h3>
                  <div class="space-y-4">
                    <div>
                      <label
                        for="current_password"
                        class="block text-sm font-medium text-gray-700 mb-1"
                        >Current Password</label
                      >
                      <input
                        id="current_password"
                        type="password"
                        v-model="security.currentPassword"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary-500"
                      />
                    </div>
                    <div>
                      <label
                        for="new_password"
                        class="block text-sm font-medium text-gray-700 mb-1"
                        >New Password</label
                      >
                      <input
                        id="new_password"
                        type="password"
                        v-model="security.newPassword"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary-500"
                      />
                    </div>
                    <div>
                      <label
                        for="confirm_password"
                        class="block text-sm font-medium text-gray-700 mb-1"
                        >Confirm Password</label
                      >
                      <input
                        id="confirm_password"
                        type="password"
                        v-model="security.confirmPassword"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary-500"
                      />
                    </div>
                  </div>
                </div>

                <div class="flex justify-end">
                  <button
                    class="px-4 py-2 bg-primary-600 text-white rounded-md hover:bg-primary-700"
                  >
                    Update Password
                  </button>
                </div>
              </div>
            </div>

            <!-- System Settings -->
            <div
              v-if="activeTab === 'system'"
              class="bg-white rounded-lg shadow overflow-hidden"
            >
              <div class="p-6 border-b">
                <h2 class="text-lg font-semibold">System Settings</h2>
                <p class="text-sm text-gray-500">
                  Configure system preferences and notification settings.
                </p>
              </div>
              <div class="p-6 space-y-6">
                <div>
                  <h3 class="font-medium mb-4">Notification Preferences</h3>
                  <div class="space-y-3">
                    <div class="flex items-center justify-between">
                      <label
                        for="email_notifications"
                        class="block text-sm font-medium text-gray-700"
                        >Email Notifications</label
                      >
                      <input
                        id="email_notifications"
                        type="checkbox"
                        v-model="system.emailNotifications"
                        class="h-4 w-4 text-primary-600 focus:ring-primary-500 border-gray-300 rounded"
                      />
                    </div>
                    <div class="flex items-center justify-between">
                      <label
                        for="sms_notifications"
                        class="block text-sm font-medium text-gray-700"
                        >SMS Notifications</label
                      >
                      <input
                        id="sms_notifications"
                        type="checkbox"
                        v-model="system.smsNotifications"
                        class="h-4 w-4 text-primary-600 focus:ring-primary-500 border-gray-300 rounded"
                      />
                    </div>
                    <div class="flex items-center justify-between">
                      <label
                        for="push_notifications"
                        class="block text-sm font-medium text-gray-700"
                        >Push Notifications</label
                      >
                      <input
                        id="push_notifications"
                        type="checkbox"
                        v-model="system.pushNotifications"
                        class="h-4 w-4 text-primary-600 focus:ring-primary-500 border-gray-300 rounded"
                      />
                    </div>
                  </div>
                </div>

                <div class="flex justify-end">
                  <button
                    class="px-4 py-2 bg-primary-600 text-white rounded-md hover:bg-primary-700"
                  >
                    Save Settings
                  </button>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </AuthenticatedLayout>
</template>

<script setup>
import { ref } from "vue";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import UpdateProfileInformationForm from "@/Pages/Profile/Partials/UpdateProfileInformationForm.vue";
import { User, Lock, Settings as SettingsIcon } from "lucide-vue-next";

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

const security = ref({
  currentPassword: "",
  newPassword: "",
  confirmPassword: "",
  twoFactorEnabled: false,
});

const system = ref({
  timezone: "UTC-5",
  dateFormat: "MM/DD/YYYY",
  emailNotifications: true,
  smsNotifications: false,
  pushNotifications: true,
});
</script>
