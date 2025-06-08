<template>
  <AuthenticatedLayout>
    <Head title="Settings" />

    <div class="min-h-screen bg-gray-50">
      <div class="bg-white shadow-sm border-b">
        <div class="container mx-auto px-4 py-4">
          <div class="flex items-center justify-between">
            <h1 class="text-2xl font-bold text-gray-900">Settings</h1>
          </div>
        </div>
      </div>

      <div class="container mx-auto px-4 py-8">
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
                      'bg-blue-50 text-blue-700': activeTab === tab.id,
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
            <div
              v-if="activeTab === 'profile'"
              class="bg-white rounded-lg shadow overflow-hidden"
            >
              <div class="p-6 border-b">
                <h2 class="text-lg font-semibold">Profile Information</h2>
                <p class="text-sm text-gray-500">
                  Update your account's profile information and email address.
                </p>
              </div>
              <div class="p-6 space-y-6">
                <div class="flex items-center space-x-6">
                  <div class="relative">
                    <div
                      class="w-16 h-16 rounded-full bg-gray-200 flex items-center justify-center"
                    >
                      <span class="text-gray-600 text-xl font-medium">A</span>
                    </div>
                    <button
                      class="absolute bottom-0 right-0 p-1 bg-white rounded-full shadow-sm border border-gray-300"
                    >
                      <Pencil class="h-4 w-4 text-gray-600" />
                    </button>
                  </div>
                  <div>
                    <button
                      class="px-4 py-2 text-sm font-medium text-blue-600 hover:text-blue-700"
                    >
                      Upload new photo
                    </button>
                    <button
                      class="px-4 py-2 text-sm font-medium text-red-600 hover:text-red-700"
                    >
                      Remove
                    </button>
                  </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                  <div>
                    <label
                      for="name"
                      class="block text-sm font-medium text-gray-700 mb-1"
                      >Name</label
                    >
                    <input
                      id="name"
                      type="text"
                      v-model="profile.name"
                      class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                    />
                  </div>
                  <div>
                    <label
                      for="email"
                      class="block text-sm font-medium text-gray-700 mb-1"
                      >Email</label
                    >
                    <input
                      id="email"
                      type="email"
                      v-model="profile.email"
                      class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                    />
                  </div>
                  <div>
                    <label
                      for="phone"
                      class="block text-sm font-medium text-gray-700 mb-1"
                      >Phone</label
                    >
                    <input
                      id="phone"
                      type="tel"
                      v-model="profile.phone"
                      class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                    />
                  </div>
                  <div>
                    <label
                      for="position"
                      class="block text-sm font-medium text-gray-700 mb-1"
                      >Position</label
                    >
                    <input
                      id="position"
                      type="text"
                      v-model="profile.position"
                      class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                    />
                  </div>
                </div>

                <div class="flex justify-end">
                  <button
                    class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700"
                  >
                    Save Changes
                  </button>
                </div>
              </div>
            </div>

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
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
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
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
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
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                      />
                    </div>
                  </div>
                </div>

                <div class="border-t pt-6">
                  <h3 class="font-medium mb-4">Two-Factor Authentication</h3>
                  <div class="flex items-center justify-between">
                    <div>
                      <p class="text-sm text-gray-700">
                        Add an extra layer of security to your account
                      </p>
                      <p class="text-xs text-gray-500">
                        Require a code when logging in from new devices
                      </p>
                    </div>
                    <button
                      @click="
                        security.twoFactorEnabled = !security.twoFactorEnabled
                      "
                      class="relative inline-flex h-6 w-11 items-center rounded-full"
                      :class="{
                        'bg-blue-600': security.twoFactorEnabled,
                        'bg-gray-200': !security.twoFactorEnabled,
                      }"
                    >
                      <span class="sr-only"
                        >Enable two-factor authentication</span
                      >
                      <span
                        class="inline-block h-4 w-4 transform rounded-full bg-white transition"
                        :class="{
                          'translate-x-6': security.twoFactorEnabled,
                          'translate-x-1': !security.twoFactorEnabled,
                        }"
                      />
                    </button>
                  </div>
                </div>

                <div class="flex justify-end">
                  <button
                    class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700"
                  >
                    Update Security
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
                  <h3 class="font-medium mb-4">General Settings</h3>
                  <div class="space-y-4">
                    <div class="flex items-center justify-between">
                      <label
                        for="timezone"
                        class="block text-sm font-medium text-gray-700"
                        >Timezone</label
                      >
                      <select
                        id="timezone"
                        v-model="system.timezone"
                        class="w-64 px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                      >
                        <option value="UTC-5">Eastern Time (UTC-5)</option>
                        <option value="UTC-6">Central Time (UTC-6)</option>
                        <option value="UTC-7">Mountain Time (UTC-7)</option>
                        <option value="UTC-8">Pacific Time (UTC-8)</option>
                      </select>
                    </div>
                    <div class="flex items-center justify-between">
                      <label
                        for="date_format"
                        class="block text-sm font-medium text-gray-700"
                        >Date Format</label
                      >
                      <select
                        id="date_format"
                        v-model="system.dateFormat"
                        class="w-64 px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                      >
                        <option value="MM/DD/YYYY">MM/DD/YYYY</option>
                        <option value="DD/MM/YYYY">DD/MM/YYYY</option>
                        <option value="YYYY-MM-DD">YYYY-MM-DD</option>
                      </select>
                    </div>
                  </div>
                </div>

                <div class="border-t pt-6">
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
                        class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded"
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
                        class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded"
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
                        class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded"
                      />
                    </div>
                  </div>
                </div>

                <div class="flex justify-end">
                  <button
                    class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700"
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
import { Head, Link } from "@inertiajs/vue3";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { User, Lock, Settings as SettingsIcon, Pencil } from "lucide-vue-next";

const activeTab = ref("profile");

const tabs = [
  { id: "profile", label: "Profile", icon: User },
  { id: "security", label: "Security", icon: Lock },
  { id: "system", label: "System", icon: SettingsIcon },
];

const profile = ref({
  name: "Administrator",
  email: "admin@funeralparlour.com",
  phone: "+1 (555) 123-4567",
  position: "System Administrator",
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
