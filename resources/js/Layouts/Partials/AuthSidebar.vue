<template>
  <aside :class="additionalClasses">
    <!-- Sidebar Header -->
    <div class="sidebar-header border-b border-gray-200 p-4">
      <div class="flex items-center justify-center">
        <Link href="/"><ApplicationLogo class="h-20" /></Link>
      </div>
    </div>

    <!-- Sidebar Content -->
    <div class="sidebar-content p-2 flex-1 overflow-y-auto">
      <!-- Main Navigation -->
      <div class="sidebar-group">
        <h4 class="sidebar-group-label">Main Navigation</h4>
        <div class="sidebar-group-content">
          <ul class="sidebar-menu">
            <li class="sidebar-menu-item">
              <Link
                href="/dashboard"
                class="sidebar-menu-button"
                :class="{
                  'bg-secondary-100 text-secondary-600':
                    $page.url === '/dashboard',
                }"
              >
                <BarChart3 class="h-4 w-4" />
                <span>Dashboard</span>
              </Link>
            </li>

            <li class="sidebar-menu-item">
              <Link
                href="/notifications"
                class="sidebar-menu-button"
                :class="{
                  'bg-secondary-100 text-secondary-600':
                    $page.url === '/notifications',
                }"
              >
                <Bell class="h-4 w-4" />
                <span>Notifications</span>
                <span
                  class="ml-auto bg-red-500 text-white text-xs rounded-full px-2 py-1"
                  >5</span
                >
              </Link>
            </li>
            <li class="sidebar-menu-item">
              <Link
                href="/documents"
                class="sidebar-menu-button"
                :class="{
                  'bg-secondary-100 text-secondary-600':
                    $page.url.startsWith('/documents'),
                }"
              >
                <Database class="h-4 w-4" />
                <span>Documents</span>
              </Link>
            </li>
            <li class="sidebar-menu-item">
              <Link
                href="/settings"
                class="sidebar-menu-button"
                :class="{
                  'bg-secondary-100 text-secondary-600':
                    $page.url.startsWith('/settings'),
                }"
              >
                <Settings class="h-4 w-4" />
                <span>Settings</span>
              </Link>
            </li>
            <li
              class="sidebar-menu-item"
              v-if="$page.props.auth.user.role === 'admin'"
            >
              <Link
                href="/admin"
                class="sidebar-menu-button"
                :class="{
                  'bg-secondary-100 text-secondary-600':
                    $page.url.startsWith('/admin'),
                }"
              >
                <Shield class="h-4 w-4" />
                <span>Admin Panel</span>
              </Link>
            </li>
          </ul>
        </div>
      </div>

      <div class="sidebar-separator"></div>

      <!-- Help & Support -->
      <div class="sidebar-group">
        <div class="sidebar-group-content">
          <ul class="sidebar-menu">
            <li class="sidebar-menu-item">
              <Link
                href="/admin/help"
                class="sidebar-menu-button"
                :class="{
                  'bg-secondary-100 text-secondary-600':
                    $page.url === '/admin/help',
                }"
              >
                <HelpCircle class="h-4 w-4" />
                <span>Help & Support</span>
              </Link>
            </li>
          </ul>
        </div>
      </div>
    </div>

    <!-- Sidebar Footer -->
    <div class="sidebar-footer border-t border-gray-200 p-4">
      <ul class="sidebar-menu">
        <li class="sidebar-menu-item">
          <Link
            href="/logout"
            method="post"
            as="button"
            class="sidebar-menu-button w-full text-red-600 hover:text-red-700 hover:bg-red-50 focus:bg-red-50 focus:text-red-700"
          >
            <LogOut class="h-4 w-4" />
            <span>Logout</span>
          </Link>
        </li>
      </ul>
    </div>
  </aside>
</template>

<script setup>
import { ref } from "vue";
import {
  BarChart3,
  Settings,
  LogOut,
  Shield,
  Database,
  HelpCircle,
  Bell,
} from "lucide-vue-next";
import ApplicationLogo from "@/Components/Ui/ApplicationLogo.vue";
import { Link } from "@inertiajs/vue3";

defineProps({
  additionalClasses: {
    type: String,
    default: "",
  },
});

const expandedItems = ref(["dashboard"]);

const isExpanded = (item) => expandedItems.value.includes(item);

const toggleExpand = (item) => {
  expandedItems.value = expandedItems.value.includes(item)
    ? expandedItems.value.filter((i) => i !== item)
    : [...expandedItems.value, item];
};
</script>

<style scoped>
.sidebar {
  width: 250px;
  min-height: 100vh !important;
  transition: transform 0.3s ease-in-out;
}

/* For mobile */
@media (max-width: 767px) {
  .sidebar {
    position: fixed;
    top: 0;
    left: 0;
    bottom: 0;
    z-index: 40;
  }
}

@media (min-width: 768px) {
  .sidebar {
    position: relative !important;
    transform: none !important;
  }
}

.sidebar-group {
  margin-bottom: 1rem;
}

.sidebar-group-label {
  @apply text-xs font-medium text-gray-500 uppercase tracking-wider px-2 py-2;
}

.sidebar-group-content {
  @apply mt-1;
}

.sidebar-menu {
  @apply space-y-1;
}

.sidebar-menu-item {
  @apply list-none;
}

.sidebar-menu-button {
  @apply flex items-center gap-3 w-full px-3 py-2 text-sm font-medium rounded-md transition-colors;
  @apply hover:bg-secondary-50 hover:text-secondary-600 focus:bg-secondary-50 focus:text-secondary-600;
}

.sidebar-menu-sub {
  @apply pl-4 mt-1;
}

.sidebar-menu-sub-item {
  @apply list-none;
}

.sidebar-menu-sub-button {
  @apply flex items-center gap-3 w-full px-3 py-2 text-sm rounded-md transition-colors;
  @apply hover:bg-gray-100 text-gray-600 hover:text-gray-800;
}

.sidebar-separator {
  @apply border-t border-gray-200 my-2;
}
</style>
