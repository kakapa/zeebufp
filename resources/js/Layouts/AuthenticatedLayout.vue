<template>
  <div class="min-h-screen bg-gray-100">
    <AuthNavbar />

    <div class="py-10">
      <header v-if="$slots.header">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
          <h1 class="text-3xl font-bold leading-tight text-gray-900">
            <slot name="header" />
          </h1>
        </div>
      </header>

      <!-- Page Content -->
      <main>
        <slot />
      </main>
    </div>
  </div>
</template>

<script setup>
import AuthNavbar from "./Partials/AuthNavbar.vue";
</script>
