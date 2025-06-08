<template>
  <header
    class="bg-white border-b border-gray-200 px-3 sm:px-6 py-3 sm:py-4 sticky top-0 z-10"
  >
    <div class="flex items-center justify-between">
      <div class="flex items-center gap-2 sm:gap-4 flex-1 min-w-0">
        <!-- Mobile sidebar toggle button -->
        <button
          @click="$emit('toggle-sidebar')"
          class="md:hidden p-1 rounded-md hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-blue-500"
        >
          <Menu class="h-5 w-5 text-gray-600" />
        </button>
        <div class="hidden sm:block">
          <h1 class="text-lg sm:text-xl font-semibold text-gray-900">
            Dashboard
          </h1>
        </div>
      </div>

      <!-- Center - Search -->
      <div class="flex-1 max-w-xs sm:max-w-md mx-2 sm:mx-4 hidden sm:block">
        <div class="relative">
          <Search
            class="absolute left-2 sm:left-3 top-1/2 transform -translate-y-1/2 text-gray-400 h-3 w-3 sm:h-4 sm:w-4"
          />
          <input
            type="search"
            placeholder="Search clients..."
            class="border border-gray-300 rounded-md pl-8 sm:pl-10 pr-2 sm:pr-4 py-1.5 sm:py-2 w-full text-sm focus:outline-none focus:ring-1 focus:ring-blue-500 focus:border-blue-500"
          />
        </div>
      </div>

      <!-- Right side - Actions and user menu -->
      <div class="flex items-center gap-1 sm:gap-3">
        <!-- Quick Actions Dropdown - Hidden on small screens -->
        <div class="hidden lg:block relative">
          <button
            @click="toggleQuickActions"
            class="flex items-center text-sm px-3 py-1.5 rounded-md hover:bg-gray-100"
          >
            Quick Actions
            <ChevronDown class="ml-1 h-3 w-3" />
          </button>

          <!-- Quick Actions Dropdown Menu -->
          <div
            v-show="showQuickActions"
            class="absolute top-full right-0 mt-1 w-64 bg-white rounded-md shadow-lg border border-gray-200 z-20"
          >
            <div class="p-2 space-y-1">
              <Link
                href="/admin/clients/create"
                class="flex items-center w-full px-3 py-2 text-sm rounded hover:bg-gray-100"
              >
                <User class="mr-2 h-4 w-4" />
                Add New Client
              </Link>
              <Link
                href="/admin/messages/compose"
                class="flex items-center w-full px-3 py-2 text-sm rounded hover:bg-gray-100"
              >
                <MessageCircle class="mr-2 h-4 w-4" />
                Send Message
              </Link>
              <Link
                href="/admin/reminders/create"
                class="flex items-center w-full px-3 py-2 text-sm rounded hover:bg-gray-100"
              >
                <Bell class="mr-2 h-4 w-4" />
                Create Reminder
              </Link>
            </div>
          </div>
        </div>

        <!-- Messages Dropdown -->
        <div class="relative">
          <button
            @click="toggleMessages"
            class="p-2 rounded-full hover:bg-gray-100 relative"
          >
            <MessageCircle class="h-6 w-6 sm:h-6 sm:w-6" />
            <span
              v-if="unreadMessages > 0"
              class="absolute -top-0.5 -right-0.5 h-4 w-4 sm:h-5 sm:w-5 rounded-full bg-red-500 text-white text-xs flex items-center justify-center"
            >
              {{ unreadMessages }}
            </span>
          </button>

          <!-- Messages Dropdown Menu -->
          <div
            v-show="showMessages"
            class="absolute right-0 mt-2 w-72 sm:w-80 bg-white rounded-md shadow-lg border border-gray-200 z-20"
          >
            <div class="py-1">
              <h3
                class="px-4 py-2 text-sm font-medium border-b border-gray-200"
              >
                Messages ({{ unreadMessages }} unread)
              </h3>
              <div class="max-h-96 overflow-y-auto">
                <div
                  v-for="message in messages"
                  :key="message.id"
                  class="px-4 py-3 hover:bg-gray-50 border-b border-gray-100 last:border-b-0"
                >
                  <div class="flex justify-between items-start">
                    <div class="flex-1 min-w-0">
                      <p class="font-medium text-sm truncate">
                        {{ message.sender }}
                      </p>
                      <p class="text-xs text-gray-600 mt-1 break-words">
                        {{ message.message }}
                      </p>
                    </div>
                    <span
                      v-if="message.unread"
                      class="w-2 h-2 bg-blue-600 rounded-full ml-2 mt-1 flex-shrink-0"
                    ></span>
                  </div>
                  <span class="text-xs text-gray-500 mt-1 block">{{
                    message.time
                  }}</span>
                </div>
              </div>
              <div class="px-4 py-2 border-t border-gray-200 text-center">
                <Link
                  href="/admin/messages"
                  class="text-sm text-blue-600 hover:underline"
                >
                  View all messages
                </Link>
              </div>
            </div>
          </div>
        </div>

        <!-- Notifications Dropdown -->
        <div class="relative">
          <button
            @click="toggleNotifications"
            class="p-2 rounded-full hover:bg-gray-100 relative"
          >
            <Bell class="h-6 w-6 sm:h-6 sm:w-6" />
            <span
              v-if="unreadNotifications > 0"
              class="absolute -top-0.5 -right-0.5 h-4 w-4 sm:h-5 sm:w-5 rounded-full bg-red-500 text-white text-xs flex items-center justify-center"
            >
              {{ unreadNotifications }}
            </span>
          </button>

          <!-- Notifications Dropdown Menu -->
          <div
            v-show="showNotifications"
            class="absolute right-0 mt-2 w-72 sm:w-80 bg-white rounded-md shadow-lg border border-gray-200 z-20"
          >
            <div class="py-1">
              <h3
                class="px-4 py-2 text-sm font-medium border-b border-gray-200"
              >
                Notifications ({{ unreadNotifications }} unread)
              </h3>
              <div class="max-h-96 overflow-y-auto">
                <div
                  v-for="notification in notifications"
                  :key="notification.id"
                  class="px-4 py-3 hover:bg-gray-50 border-b border-gray-100 last:border-b-0"
                >
                  <p class="font-medium text-sm break-words">
                    {{ notification.title }}
                  </p>
                  <span class="text-xs text-gray-500">{{
                    notification.time
                  }}</span>
                  <span
                    v-if="notification.unread"
                    class="w-2 h-2 bg-blue-600 rounded-full ml-2 mt-1 flex-shrink-0"
                  ></span>
                </div>
              </div>
              <div class="px-4 py-2 border-t border-gray-200 text-center">
                <Link
                  href="/admin/notifications"
                  class="text-sm text-blue-600 hover:underline"
                >
                  View all notifications
                </Link>
              </div>
            </div>
          </div>
        </div>

        <!-- User Menu -->
        <div class="relative">
          <button
            @click="toggleUserMenu"
            class="flex items-center gap-1 sm:gap-2 pl-1 sm:pl-2 pr-1 rounded-md hover:bg-gray-100"
          >
            <div
              class="h-8 w-8 sm:h-7 sm:w-7 rounded-full bg-purple-600 flex items-center justify-center text-white text-xs sm:text-sm"
            >
              {{ $page.props.auth.user.initials }}
            </div>
            <div class="hidden lg:block text-left">
              <p class="text-sm font-medium">
                {{ $page.props.auth.user.name }}
              </p>
            </div>
            <ChevronDown class="h-3 w-3 sm:h-4 sm:w-4" />
          </button>

          <!-- User Dropdown Menu -->
          <div
            v-show="showUserMenu"
            class="absolute right-0 mt-2 w-56 bg-white rounded-md shadow-lg border border-gray-200 z-20"
          >
            <div class="py-1">
              <h3
                class="px-4 py-2 text-sm font-medium border-b border-gray-200"
              >
                My Account
              </h3>
              <div class="border-b border-gray-200">
                <Link
                  href="/admin/settings"
                  class="flex items-center px-4 py-2 text-sm hover:bg-gray-100"
                >
                  <Settings class="mr-2 h-4 w-4" />
                  Settings
                </Link>
              </div>
              <div class="border-t border-gray-200">
                <Link
                  href="/logout"
                  method="post"
                  as="button"
                  class="flex items-center w-full px-4 py-2 text-sm text-red-600 hover:bg-gray-100"
                >
                  <LogOut class="mr-2 h-4 w-4" />
                  Log out
                </Link>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </header>
</template>

<script setup>
import { ref } from "vue";
import {
  Bell,
  MessageCircle,
  Search,
  Settings,
  User,
  LogOut,
  ChevronDown,
  Menu,
} from "lucide-vue-next";

// Define emits for parent communication
const emit = defineEmits(["toggleSidebar"]);

// State for dropdown menus
const showQuickActions = ref(false);
const showMessages = ref(false);
const showNotifications = ref(false);
const showUserMenu = ref(false);

// Toggle functions for dropdowns
const toggleQuickActions = () => {
  showQuickActions.value = !showQuickActions.value;
  // Close other dropdowns
  showMessages.value = false;
  showNotifications.value = false;
  showUserMenu.value = false;
};

const toggleMessages = () => {
  showMessages.value = !showMessages.value;
  // Close other dropdowns
  showQuickActions.value = false;
  showNotifications.value = false;
  showUserMenu.value = false;
};

const toggleNotifications = () => {
  showNotifications.value = !showNotifications.value;
  // Close other dropdowns
  showQuickActions.value = false;
  showMessages.value = false;
  showUserMenu.value = false;
};

const toggleUserMenu = () => {
  showUserMenu.value = !showUserMenu.value;
  // Close other dropdowns
  showQuickActions.value = false;
  showMessages.value = false;
  showNotifications.value = false;
};

// Close dropdowns when clicking outside
const handleClickOutside = (event) => {
  if (!event.target.closest(".relative")) {
    showQuickActions.value = false;
    showMessages.value = false;
    showNotifications.value = false;
    showUserMenu.value = false;
  }
};

// Add click outside listener
document.addEventListener("click", handleClickOutside);

// Sample data
const notifications = ref([
  { id: 1, title: "New claim submitted", time: "2 minutes ago", unread: true },
  { id: 2, title: "Payment received", time: "1 hour ago", unread: true },
  { id: 3, title: "Monthly report ready", time: "3 hours ago", unread: false },
]);

const messages = ref([
  {
    id: 1,
    sender: "John Smith",
    message: "Query about my policy",
    time: "5 mins ago",
    unread: true,
  },
  {
    id: 2,
    sender: "Maria Garcia",
    message: "Thank you for the service",
    time: "1 hour ago",
    unread: true,
  },
  {
    id: 3,
    sender: "Robert Johnson",
    message: "Payment confirmation needed",
    time: "2 hours ago",
    unread: false,
  },
]);

// Computed unread counts
const unreadNotifications = notifications.value.filter((n) => n.unread).length;
const unreadMessages = messages.value.filter((m) => m.unread).length;
</script>
