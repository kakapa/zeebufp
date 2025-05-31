<template>
  <nav class="bg-white shadow-md">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="flex justify-between h-20">
        <div class="flex items-center">
          <Link href="/" class="flex-shrink-0 flex items-center">
            <ApplicationLogo class="h-14 w-auto" />
          </Link>
          <div class="hidden md:ml-6 md:flex md:space-x-8">
            <Link
              href="/"
              class="nav-link"
              :class="{ 'nav-link-active': currentRoute === '/' }"
              >Home</Link
            >
            <Link
              href="/about"
              class="nav-link"
              :class="{ 'nav-link-active': currentRoute === '/about' }"
            >
              About Us</Link
            >
            <Link
              href="/contact"
              class="nav-link"
              :class="{ 'nav-link-active': currentRoute === '/contact' }"
              >Contact</Link
            >
            <Link
              href="/resume"
              class="nav-link"
              :class="{ 'nav-link-active': currentRoute === '/resume' }"
              >=> Resume</Link
            >
          </div>
        </div>
        <div v-if="$page.props.auth.user" class="hidden md:flex items-center">
          <Link
            href="/dashboard"
            class="px-4 py-2 text-sm font-medium text-white bg-primary-500 rounded-md hover:bg-primary-600"
          >
            Dashboard</Link
          >
        </div>
        <div v-else="$page.props.auth.user" class="hidden md:flex items-center">
          <Link
            href="/login"
            class="px-4 py-2 text-sm font-medium text-gray-700 hover:text-primary-500 mr-2"
          >
            Login</Link
          >
          <Link
            href="/register"
            class="px-4 py-2 text-sm font-medium text-white bg-primary-500 rounded-md hover:bg-primary-600"
          >
            Register</Link
          >
        </div>
        <div class="flex items-center md:hidden">
          <button
            @click="isOpen = !isOpen"
            class="inline-flex items-center justify-center p-2 rounded-md text-gray-700 hover:text-primary-500 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500"
          >
            <span class="sr-only">Open main menu</span>
            <MenuIcon v-if="!isOpen" class="block h-6 w-6" />
            <XIcon v-else class="block h-6 w-6" />
          </button>
        </div>
      </div>
    </div>

    <!-- Mobile menu -->
    <div v-if="isOpen" class="md:hidden">
      <div class="pt-2 pb-3 space-y-1">
        <Link href="/" class="mobile-nav-link" @click="isOpen = false"
          >Home</Link
        >
        <Link href="/about" class="mobile-nav-link" @click="isOpen = false"
          >About Us</Link
        >
        <Link href="/contact" class="mobile-nav-link" @click="isOpen = false"
          >Contact</Link
        >
      </div>
      <div class="pt-4 pb-3 border-t border-gray-200">
        <div v-if="$page.props.auth.user" class="flex items-center px-4">
          <div class="flex-shrink-0">
            <UserCircleIcon class="h-10 w-10 text-gray-400" />
          </div>
          <div class="ml-3">
            <Link href="/dashboard">
              <div class="text-base font-medium text-gray-800">Dashboard</div>
            </Link>
          </div>
        </div>
        <div v-else class="mt-3 space-y-1">
          <Link href="/login" class="mobile-nav-link" @click="isOpen = false"
            >Login</Link
          >
          <Link href="/register" class="mobile-nav-link" @click="isOpen = false"
            >Register</Link
          >
        </div>
      </div>
    </div>
  </nav>
</template>

<script setup>
import { ref, computed } from "vue";
import { Link } from "@inertiajs/vue3";
import { MenuIcon, XIcon, UserCircleIcon } from "lucide-vue-next";
import ApplicationLogo from "@/Components/ApplicationLogo.vue";

const isOpen = ref(false);
const currentRoute = computed(() => route.path);
</script>

<style scoped>
.nav-link {
  @apply inline-flex items-center px-1 pt-1 border-b-2 border-transparent text-sm font-medium text-gray-700 hover:text-primary-500 hover:border-primary-300;
}

.nav-link-active {
  @apply border-primary-500 text-primary-600;
}

.mobile-nav-link {
  @apply block pl-3 pr-4 py-2 border-l-4 border-transparent text-base font-medium text-gray-700 hover:bg-gray-50 hover:border-primary-300 hover:text-primary-500;
}
</style>
