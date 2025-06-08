<template>
  <div class="flex h-screen w-full bg-gray-50 relative">
    <!-- Mobile overlay (only shown on mobile when sidebar is open) -->
    <div
      v-if="sidebarOpen"
      class="fixed inset-0 bg-black bg-opacity-50 z-20 md:hidden transition-opacity duration-300"
      @click="sidebarOpen = false"
    ></div>

    <!-- Sidebar -->
    <AuthSidebar
      class="fixed md:relative inset-y-0 left-0 z-40 w-64 bg-white border-r border-gray-200 flex flex-col transition-transform duration-300 ease-in-out md:transition-none"
      :class="{
        '-translate-x-full md:translate-x-0': !sidebarOpen,
        'translate-x-0': sidebarOpen,
      }"
    />

    <!-- Main Content -->
    <div class="flex-1 flex flex-col min-w-0">
      <!-- Navbar -->
      <AuthNavbar @toggle-sidebar="sidebarOpen = !sidebarOpen" />

      <!-- Page Content -->
      <main class="flex-1 p-3 sm:p-6 overflow-auto">
        <slot />
      </main>
    </div>
  </div>
</template>

<script setup>
import { ref } from "vue";
import AuthSidebar from "./Partials/AuthSidebar.vue";
import AuthNavbar from "./Partials/AuthNavbar.vue";

const sidebarOpen = ref(false);
</script>
