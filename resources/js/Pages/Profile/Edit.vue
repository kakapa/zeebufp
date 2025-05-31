<template>
  <Head title="Profile" />

  <AuthenticatedLayout>
    <template #header>
      <span>My Profile</span>
    </template>

    <div class="py-12">
      <div class="mx-auto max-w-7xl space-y-6 sm:px-6 lg:px-8">
        <!-- Tabs -->
        <div class="bg-gray-100 rounded-lg mb-8">
          <nav class="flex">
            <button
              @click="activeTab = 'profile'"
              class="px-6 py-4 text-lg font-medium rounded-tl-lg flex items-center"
              :class="
                activeTab === 'profile'
                  ? 'bg-white text-gray-900'
                  : 'text-gray-500 hover:text-gray-700'
              "
            >
              <UserIcon class="h-5 w-5 mr-2" />
              About You
            </button>
            <button
              @click="activeTab = 'password'"
              class="px-6 py-4 text-lg font-medium flex items-center"
              :class="
                activeTab === 'password'
                  ? 'bg-white text-gray-900'
                  : 'text-gray-500 hover:text-gray-700'
              "
            >
              <LockIcon class="h-5 w-5 mr-2" />
              Password
            </button>
            <button
              @click="activeTab = 'notifications'"
              class="px-6 py-4 text-lg font-medium flex items-center"
              :class="
                activeTab === 'notifications'
                  ? 'bg-white text-gray-900'
                  : 'text-gray-500 hover:text-gray-700'
              "
            >
              <BellIcon class="h-5 w-5 mr-2" />
              Notifications
            </button>
            <button
              @click="activeTab = 'privacy'"
              class="px-6 py-4 text-lg font-medium rounded-tr-lg flex items-center"
              :class="
                activeTab === 'privacy'
                  ? 'bg-white text-gray-900'
                  : 'text-gray-500 hover:text-gray-700'
              "
            >
              <ShieldIcon class="h-5 w-5 mr-2" />
              Privacy
            </button>
          </nav>
        </div>

        <!-- Tab Content -->
        <div class="bg-white rounded-lg p-8 shadow">
          <!-- Profile Tab -->
          <UpdateProfileInformationForm
            :must-verify-email="mustVerifyEmail"
            :status="status"
            :countries="countries"
            :genderItems="genderItems"
            :maritalStatusItems="maritalStatusItems"
            :workStatusItems="workStatusItems"
            :educationLevelItems="educationLevelItems"
            :sourceItems="sourceItems"
            :occupations="occupations"
            :activeTab="activeTab"
          />

          <!-- Password Tab -->
          <UpdatePasswordForm class="max-w-xl" :activeTab="activeTab" />

          <!-- Notifications Tab -->
          <div v-if="activeTab === 'notifications'">
            <h2 class="text-3xl font-bold text-gray-900 mb-8">
              Notification Preferences
            </h2>

            <div class="max-w-3xl">
              <div class="space-y-6">
                <div class="relative flex items-start">
                  <div class="flex items-center h-5">
                    <input
                      id="email-notifications"
                      type="checkbox"
                      v-model="notificationPreferences.email"
                      class="h-4 w-4 text-primary-500 border-gray-300 rounded focus:ring-primary-500"
                    />
                  </div>
                  <div class="ml-3 text-sm">
                    <label
                      for="email-notifications"
                      class="font-medium text-gray-700"
                      >Email Notifications</label
                    >
                    <p class="text-gray-500">
                      Receive email notifications about events, updates, and
                      community activities.
                    </p>
                  </div>
                </div>

                <div class="relative flex items-start">
                  <div class="flex items-center h-5">
                    <input
                      id="sms-notifications"
                      type="checkbox"
                      v-model="notificationPreferences.sms"
                      class="h-4 w-4 text-primary-500 border-gray-300 rounded focus:ring-primary-500"
                    />
                  </div>
                  <div class="ml-3 text-sm">
                    <label
                      for="sms-notifications"
                      class="font-medium text-gray-700"
                      >SMS Notifications</label
                    >
                    <p class="text-gray-500">
                      Receive text message notifications for important updates
                      and reminders.
                    </p>
                  </div>
                </div>

                <div class="relative flex items-start">
                  <div class="flex items-center h-5">
                    <input
                      id="newsletter"
                      type="checkbox"
                      v-model="notificationPreferences.newsletter"
                      class="h-4 w-4 text-primary-500 border-gray-300 rounded focus:ring-primary-500"
                    />
                  </div>
                  <div class="ml-3 text-sm">
                    <label for="newsletter" class="font-medium text-gray-700"
                      >Newsletter</label
                    >
                    <p class="text-gray-500">
                      Receive our monthly newsletter with community news and
                      updates.
                    </p>
                  </div>
                </div>

                <div class="relative flex items-start">
                  <div class="flex items-center h-5">
                    <input
                      id="event-reminders"
                      type="checkbox"
                      v-model="notificationPreferences.eventReminders"
                      class="h-4 w-4 text-primary-500 border-gray-300 rounded focus:ring-primary-500"
                    />
                  </div>
                  <div class="ml-3 text-sm">
                    <label
                      for="event-reminders"
                      class="font-medium text-gray-700"
                      >Event Reminders</label
                    >
                    <p class="text-gray-500">
                      Receive reminders about upcoming events you've registered
                      for.
                    </p>
                  </div>
                </div>
              </div>

              <div class="mt-8 flex justify-end">
                <button
                  type="button"
                  class="mr-3 px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500"
                >
                  Cancel
                </button>
                <button
                  type="button"
                  @click="saveNotificationPreferences"
                  class="px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-primary-500 hover:bg-primary-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500"
                >
                  Save Preferences
                </button>
              </div>
            </div>
          </div>

          <!-- Privacy Tab -->
          <div v-if="activeTab === 'privacy'">
            <h2 class="text-3xl font-bold text-gray-900 mb-8">
              Privacy Settings
            </h2>

            <div class="max-w-3xl">
              <div class="space-y-6">
                <div class="relative flex items-start">
                  <div class="flex items-center h-5">
                    <input
                      id="profile-visibility"
                      type="checkbox"
                      v-model="privacySettings.profileVisibility"
                      class="h-4 w-4 text-primary-500 border-gray-300 rounded focus:ring-primary-500"
                    />
                  </div>
                  <div class="ml-3 text-sm">
                    <label
                      for="profile-visibility"
                      class="font-medium text-gray-700"
                      >Public Profile</label
                    >
                    <p class="text-gray-500">
                      Make your profile visible to other VILTURA members.
                    </p>
                  </div>
                </div>

                <div class="relative flex items-start">
                  <div class="flex items-center h-5">
                    <input
                      id="contact-info"
                      type="checkbox"
                      v-model="privacySettings.contactInfo"
                      class="h-4 w-4 text-primary-500 border-gray-300 rounded focus:ring-primary-500"
                    />
                  </div>
                  <div class="ml-3 text-sm">
                    <label for="contact-info" class="font-medium text-gray-700"
                      >Show Contact Information</label
                    >
                    <p class="text-gray-500">
                      Allow other members to see your contact information.
                    </p>
                  </div>
                </div>

                <div class="relative flex items-start">
                  <div class="flex items-center h-5">
                    <input
                      id="activity-tracking"
                      type="checkbox"
                      v-model="privacySettings.activityTracking"
                      class="h-4 w-4 text-primary-500 border-gray-300 rounded focus:ring-primary-500"
                    />
                  </div>
                  <div class="ml-3 text-sm">
                    <label
                      for="activity-tracking"
                      class="font-medium text-gray-700"
                      >Activity Tracking</label
                    >
                    <p class="text-gray-500">
                      Allow VILTURA to track your activity on the platform for a
                      better experience.
                    </p>
                  </div>
                </div>

                <div class="relative flex items-start">
                  <div class="flex items-center h-5">
                    <input
                      id="data-sharing"
                      type="checkbox"
                      v-model="privacySettings.dataSharing"
                      class="h-4 w-4 text-primary-500 border-gray-300 rounded focus:ring-primary-500"
                    />
                  </div>
                  <div class="ml-3 text-sm">
                    <label for="data-sharing" class="font-medium text-gray-700"
                      >Data Sharing</label
                    >
                    <p class="text-gray-500">
                      Allow VILTURA to share anonymized data with partners for
                      research purposes.
                    </p>
                  </div>
                </div>
              </div>

              <div class="mt-8">
                <h3 class="text-lg font-medium text-gray-900 mb-4">
                  Data Management
                </h3>
                <div class="space-y-4">
                  <button
                    type="button"
                    class="px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 me-2"
                  >
                    Download My Data
                  </button>
                  <button
                    type="button"
                    class="px-4 py-2 border border-red-300 rounded-md shadow-sm text-sm font-medium text-red-700 bg-white hover:bg-red-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500"
                  >
                    Delete My Account
                  </button>
                </div>
              </div>

              <div class="mt-8 flex justify-end">
                <button
                  type="button"
                  class="mr-3 px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500"
                >
                  Cancel
                </button>
                <button
                  type="button"
                  @click="savePrivacySettings"
                  class="px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-primary-500 hover:bg-primary-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500"
                >
                  Save Settings
                </button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </AuthenticatedLayout>
</template>

<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
//import DeleteUserForm from "./Partials/DeleteUserForm.vue";
import UpdatePasswordForm from "./Partials/UpdatePasswordForm.vue";
import UpdateProfileInformationForm from "./Partials/UpdateProfileInformationForm.vue";
import { ref, reactive } from "vue";
import { BellIcon, UserIcon, LockIcon, ShieldIcon } from "lucide-vue-next";

const activeTab = ref("profile");

// Notification preferences
const notificationPreferences = reactive({
  email: true,
  sms: false,
  newsletter: true,
  eventReminders: true,
});

// Privacy settings
const privacySettings = reactive({
  profileVisibility: true,
  contactInfo: false,
  activityTracking: true,
  dataSharing: false,
});

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
