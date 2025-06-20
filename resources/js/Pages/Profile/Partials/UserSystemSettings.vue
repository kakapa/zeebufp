<template>
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

    <form @submit.prevent="handleSubmit">
      <div class="p-6 space-y-6">
        <div>
          <h3 class="font-medium mb-4">Notification Preferences</h3>
          <div class="space-y-3">
            <div
              class="flex items-center justify-between"
              v-for="(value, key) in form.data()"
              :key="key"
            >
              <label :for="key" class="block text-sm font-medium text-gray-700">
                {{ labels[key] ?? key }}
              </label>
              <input
                type="checkbox"
                :id="key"
                v-model="form[key]"
                class="h-4 w-4 text-primary-600 focus:ring-primary-500 border-gray-300 rounded"
              />
            </div>
          </div>
        </div>

        <div class="flex justify-end">
          <PrimaryButton :disabled="form.processing">
            Save Settings
          </PrimaryButton>
        </div>
      </div>
    </form>
  </div>
</template>

<script setup>
import PrimaryButton from "@/Components/Ui/PrimaryButton.vue";
import { useForm, usePage } from "@inertiajs/vue3";
import { useToast } from "vue-toast-notification";

defineProps({
  activeTab: {
    type: String,
    default: "system",
  },
});

const labels = {
  email_me: "Email Notifications",
  sms_me: "SMS Notifications",
  whatsapp_me: "WhatsApp Notifications",
  call_me: "Call Notifications",
};

// Access settingsArray from the user
const settings = usePage().props.auth.user.settingsArray ?? {};
const toast = useToast();

// Flatten the notification settings into the form
const form = useForm({
  ...settings.notifications,
});

const handleSubmit = () => {
  form.post(route("settings.update"), {
    preserveScroll: true,
    onSuccess: () => {
      toast.success("Settings successfully updated!", {
        position: "top-right",
      });
    },
  });
};
</script>
