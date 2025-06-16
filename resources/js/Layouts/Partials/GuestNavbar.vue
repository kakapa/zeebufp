<template>
  <header
    class="bg-white shadow-lg fixed w-full top-0 z-50 border-b border-gray-100"
  >
    <div class="container mx-auto px-4">
      <!-- Top bar with contact info -->
      <div
        class="hidden md:flex justify-between items-center py-2 text-sm text-gray-600 border-b border-gray-100"
      >
        <div class="flex items-center space-x-6">
          <span class="font-dancing text-lg text-brand-purple"
            >Dignity without limits</span
          >
        </div>
        <div class="flex items-center space-x-4">
          <div class="flex items-center space-x-2">
            <svg
              xmlns="http://www.w3.org/2000/svg"
              width="16"
              height="16"
              viewBox="0 0 24 24"
              fill="none"
              stroke="currentColor"
              stroke-width="2"
              stroke-linecap="round"
              stroke-linejoin="round"
              class="text-brand-orange"
            >
              <path
                d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"
              ></path>
            </svg>
            <span class="font-semibold text-gray-800">083 867 7800</span>
          </div>
          <span class="text-brand-orange">|</span>
          <span>24/7 Support Available</span>
        </div>
      </div>

      <!-- Main navigation -->
      <div class="flex items-center justify-between py-4">
        <div class="flex items-center space-x-4">
          <Link href="/" class="flex-shrink-0 flex items-center">
            <ApplicationLogo class="h-14 w-auto" />
          </Link>
        </div>

        <nav class="hidden md:flex items-center space-x-8">
          <Link
            href="#home"
            class="text-gray-700 hover:text-brand-purple transition-colors font-medium"
            >Home</Link
          >
          <Link
            href="#about"
            class="text-gray-700 hover:text-brand-purple transition-colors font-medium"
            >About Us</Link
          >
          <Link
            href="#services"
            class="text-gray-700 hover:text-brand-purple transition-colors font-medium"
            >Services</Link
          >
          <Link
            href="#packages"
            class="text-gray-700 hover:text-brand-purple transition-colors font-medium"
            >Funeral Cover</Link
          >
          <Link
            href="#gallery"
            class="text-gray-700 hover:text-brand-purple transition-colors font-medium"
            >Gallery</Link
          >
        </nav>

        <div class="hidden md:flex items-center space-x-4">
          <Link
            v-if="$page.props.auth.user"
            href="/dashboard"
            class="bg-brand-purple hover:bg-purple-500 text-white px-6 py-2 rounded-lg font-medium transition-colors"
          >
            Dashboard
          </Link>
          <Link
            href="#contact"
            v-else
            class="bg-brand-gold hover:bg-yellow-600 text-white px-6 py-2 rounded-lg font-medium transition-colors"
          >
            Contact Us
          </Link>
        </div>

        <button class="md:hidden p-2" @click="isMenuOpen = !isMenuOpen">
          <svg
            v-if="isMenuOpen"
            xmlns="http://www.w3.org/2000/svg"
            width="24"
            height="24"
            viewBox="0 0 24 24"
            fill="none"
            stroke="currentColor"
            stroke-width="2"
            stroke-linecap="round"
            stroke-linejoin="round"
          >
            <line x1="18" y1="6" x2="6" y2="18"></line>
            <line x1="6" y1="6" x2="18" y2="18"></line>
          </svg>
          <svg
            v-else
            xmlns="http://www.w3.org/2000/svg"
            width="24"
            height="24"
            viewBox="0 0 24 24"
            fill="none"
            stroke="currentColor"
            stroke-width="2"
            stroke-linecap="round"
            stroke-linejoin="round"
          >
            <line x1="3" y1="12" x2="21" y2="12"></line>
            <line x1="3" y1="6" x2="21" y2="6"></line>
            <line x1="3" y1="18" x2="21" y2="18"></line>
          </svg>
        </button>
      </div>

      <!-- Mobile menu -->
      <div
        v-if="isMenuOpen"
        class="md:hidden pb-4 border-t border-gray-100 animate-fade-in"
      >
        <nav class="flex flex-col space-y-4 mt-4">
          <Link
            href="#home"
            class="text-gray-700 hover:text-brand-purple transition-colors font-medium"
            >Home</Link
          >
          <Link
            href="#about"
            class="text-gray-700 hover:text-brand-purple transition-colors font-medium"
            >About Us</Link
          >
          <Link
            href="#services"
            class="text-gray-700 hover:text-brand-purple transition-colors font-medium"
            >Services</Link
          >
          <Link
            href="#packages"
            class="text-gray-700 hover:text-brand-purple transition-colors font-medium"
            >Funeral Cover</Link
          >
          <Link
            href="#gallery"
            class="text-gray-700 hover:text-brand-purple transition-colors font-medium"
            >Gallery</Link
          >
          <Link
            href="#contact"
            class="text-gray-700 hover:text-brand-purple transition-colors font-medium"
            >Contact</Link
          >
          <div
            class="flex items-center space-x-2 pt-4 border-t border-gray-100"
          >
            <svg
              xmlns="http://www.w3.org/2000/svg"
              width="16"
              height="16"
              viewBox="0 0 24 24"
              fill="none"
              stroke="currentColor"
              stroke-width="2"
              stroke-linecap="round"
              stroke-linejoin="round"
              class="text-brand-orange"
            >
              <path
                d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"
              ></path>
            </svg>
            <span class="font-semibold text-gray-800">083 867 7800</span>
          </div>
          <Link
            v-if="$page.props.auth.user"
            href="/dashboard"
            class="px-4 py-2 text-sm font-medium text-white bg-primary-500 rounded-md hover:bg-primary-600"
          >
            Dashboard
          </Link>
          <button
            v-else
            class="bg-brand-gold hover:bg-yellow-600 text-white px-6 py-2 rounded-lg font-medium transition-colors w-full"
          >
            Contact Us
          </button>
        </nav>
      </div>
    </div>
  </header>
</template>

<script setup>
import { ref } from "vue";
import { Link } from "@inertiajs/vue3";
import ApplicationLogo from "@/Components/Ui/ApplicationLogo.vue";

const isMenuOpen = ref(false);
</script>

<style>
/* Add any custom styles here */
.font-dancing {
  font-family: "Dancing Script", cursive;
}

.animate-fade-in {
  animation: fadeIn 0.3s ease-in-out;
}

@keyframes fadeIn {
  from {
    opacity: 0;
    transform: translateY(-10px);
  }
  to {
    opacity: 1;
    transform: translateY(0);
  }
}

/* Brand colors - adjust as needed */
.text-brand-purple {
  color: #6b46c1;
}
.text-brand-orange {
  color: #dd6b20;
}
.bg-brand-gold {
  background-color: #d69e2e;
}
.bg-brand-purple {
  background-color: #6b46c1;
}
</style>
