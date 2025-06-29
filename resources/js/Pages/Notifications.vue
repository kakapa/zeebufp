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
              'bg-secondary-50': !notification.read_at,
            }"
          >
            <div
              class="w-10 h-10 rounded-full bg-gray-200 flex items-center justify-center text-gray-600 font-medium"
            >
              <component
                :is="dynamicIcon(notification.data?.icon)"
                class="h-6 w-6"
                :style="{ color: notification.data?.color || '#4F46E5' }"
              />
            </div>
            <div class="flex-1 min-w-0">
              <div class="flex justify-between items-center">
                <h3 class="text-sm font-semibold text-gray-900">
                  {{ notification.data.short }}
                </h3>
                <span class="text-xs text-gray-500">{{
                  notification.created_at
                    ? new Date(notification.created_at).toLocaleString(
                        "en-ZA",
                        {
                          month: "short",
                          day: "numeric",
                          hour: "2-digit",
                          minute: "2-digit",
                        }
                      )
                    : "Just now"
                }}</span>
              </div>
              <p class="text-sm text-gray-600 mt-1">
                {{ notification.data.long }}
              </p>
            </div>
            <button
              @click="markAsRead(notification.id)"
              class="text-xs text-primary-600 hover:underline"
              v-if="!notification.read_at"
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
import { Head, router } from "@inertiajs/vue3";
import * as lucideIcons from "lucide-vue-next";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";

const props = defineProps({
  allNotifications: Array,
});

const notifications = ref(props.allNotifications);

const dynamicIcon = (iconName) => {
  return lucideIcons[iconName] || lucideIcons.MessageCircle;
};

const markAsRead = (id) => {
  const notification = notifications.value.find((n) => n.id === id);
  if (notification) {
    router.post(
      route("notifications.read", id),
      {},
      {
        onSuccess: () => {
          notification.read_at = new Date().toISOString();
        },
        onError: (error) => {
          console.error("Failed to mark notification as read:", error);
        },
      }
    );
  }
};
</script>
