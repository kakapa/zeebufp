<template>
  <AuthenticatedLayout>
    <Head title="Notifications" />

    <div class="container mx-auto px-4 py-8 space-y-6">
      <!-- Header -->
      <div
        class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4"
      >
        <div>
          <h2 class="text-2xl font-bold">Notifications</h2>
          <p class="text-gray-600">
            Stay informed with the latest system updates, alerts, and user
            activity.
          </p>
        </div>
      </div>

      <!-- Notification List -->
      <div class="bg-white shadow rounded-lg overflow-hidden">
        <div class="divide-y divide-gray-200">
          <div
            v-for="notification in notifications"
            :key="notification.id"
            class="p-4 hover:bg-gray-50 flex items-start space-x-4"
            :class="{
              'bg-secondary-50': !notification.read,
            }"
          >
            <div
              class="w-10 h-10 rounded-full bg-gray-200 flex items-center justify-center text-gray-600 font-medium"
            >
              {{ notification.initials }}
            </div>
            <div class="flex-1 min-w-0">
              <div class="flex justify-between items-center">
                <h3 class="text-sm font-semibold text-gray-900">
                  {{ notification.title }}
                </h3>
                <span class="text-xs text-gray-500">{{
                  notification.time
                }}</span>
              </div>
              <p class="text-sm text-gray-600 mt-1">
                {{ notification.message }}
              </p>
            </div>
            <button
              @click="markAsRead(notification.id)"
              class="text-xs text-primary-600 hover:underline"
              v-if="!notification.read"
            >
              Mark as read
            </button>
          </div>
          <div
            v-if="notifications.length === 0"
            class="p-4 text-center text-gray-500"
          >
            No new notifications
          </div>
        </div>
      </div>
    </div>
  </AuthenticatedLayout>
</template>

<script setup>
import { ref } from "vue";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head } from "@inertiajs/vue3";

const notifications = ref([
  {
    id: 1,
    title: "Claim Approved",
    message: "Your funeral claim #2391 has been successfully approved.",
    initials: "FA",
    time: "2h ago",
    read: false,
  },
  {
    id: 2,
    title: "New Message from Support",
    message: "A support agent has replied to your recent query.",
    initials: "SS",
    time: "5h ago",
    read: false,
  },
  {
    id: 3,
    title: "Payment Reminder",
    message: "Your policy payment for June is due in 3 days.",
    initials: "PM",
    time: "Yesterday",
    read: true,
  },
  {
    id: 4,
    title: "Plan Update",
    message: "Premium Funeral Plan benefits have been updated.",
    initials: "UP",
    time: "2 days ago",
    read: true,
  },
]);

const markAsRead = (id) => {
  const notification = notifications.value.find((n) => n.id === id);
  if (notification) {
    notification.read = true;
  }
};
</script>
