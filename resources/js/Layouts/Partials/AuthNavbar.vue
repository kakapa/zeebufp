<template>
  <nav class="bg-white shadow-sm">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="flex justify-between h-16">
        <div class="flex">
          <div class="flex-shrink-0 flex items-center">
            <Link href="/">
              <ApplicationLogo class="h-10 w-auto" />
            </Link>
          </div>
          <div class="hidden sm:ml-6 sm:flex sm:space-x-8">
            <NavLink
              :href="route('dashboard')"
              :active="route().current('dashboard')"
            >
              Dashboard
            </NavLink>
            <a
              href="#"
              class="border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700 inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium"
            >
              Events
            </a>

            <div
              class="relative flex flex-column"
              @mouseleave="dropdowns.resources = false"
            >
              <button
                @click="toggleDropdown('resources')"
                @mouseover="dropdowns.resources = true"
                class="border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700 inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium"
              >
                Resources
                <ChevronDownIcon
                  class="ml-1 h-4 w-4"
                  :class="{ 'transform rotate-180': dropdowns.resources }"
                />
              </button>
              <div
                v-if="dropdowns.resources"
                class="absolute top-14 left-0 mt-2 w-72 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 focus:outline-none z-10"
              >
                <div class="py-1">
                  <a
                    href="#"
                    class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100"
                  >
                    <span class="inline-block w-6 text-center mr-2">📄</span>
                    Documents & Policies
                  </a>
                  <a
                    href="#"
                    class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100"
                  >
                    <span class="inline-block w-6 text-center mr-2">📊</span>
                    Reports & Publications
                  </a>
                  <a
                    href="#"
                    class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100"
                  >
                    <span class="inline-block w-6 text-center mr-2">💡</span>
                    Guides & Toolkits
                  </a>
                  <a
                    href="#"
                    class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100"
                  >
                    <span class="inline-block w-6 text-center mr-2">🎥</span>
                    Media Library
                  </a>
                  <a
                    href="#"
                    class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100"
                  >
                    <span class="inline-block w-6 text-center mr-2">🎙</span>
                    Press Releases
                  </a>
                  <a
                    href="#"
                    class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100"
                  >
                    <span class="inline-block w-6 text-center mr-2">📝</span>
                    Forms & Applications
                  </a>
                </div>
              </div>
            </div>

            <a
              href="#"
              class="border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700 inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium"
            >
              Community
            </a>
          </div>
        </div>
        <div class="hidden sm:ml-6 sm:flex sm:items-center">
          <button
            class="bg-white p-1 rounded-full text-gray-400 hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500"
          >
            <span class="sr-only">View notifications</span>
            <BellIcon class="h-6 w-6" />
          </button>

          <!-- Profile dropdown -->
          <div class="ml-3 relative">
            <div>
              <button
                @click="profileDropdownOpen = !profileDropdownOpen"
                class="bg-white flex text-sm rounded-full focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500"
                id="user-menu-button"
              >
                <span class="sr-only">Open user menu</span>
                <img
                  class="h-8 w-8 rounded-full"
                  src="https://randomuser.me/api/portraits/men/1.jpg"
                  alt="User profile"
                />
              </button>
            </div>
            <div
              v-if="profileDropdownOpen"
              class="origin-top-right absolute right-0 mt-2 w-48 rounded-md shadow-lg py-1 bg-white ring-1 ring-black ring-opacity-5 focus:outline-none"
              role="menu"
            >
              <DropdownLink :href="route('profile.edit')">
                Your Profile
              </DropdownLink>
              <a
                href="#"
                class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100"
                role="menuitem"
                >Settings</a
              >
              <DropdownLink :href="route('logout')" method="post" as="button">
                Sign out
              </DropdownLink>
            </div>
          </div>
        </div>
        <div class="-mr-2 flex items-center sm:hidden">
          <!-- Mobile menu button -->
          <button
            @click="mobileMenuOpen = !mobileMenuOpen"
            class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500"
          >
            <span class="sr-only">Open main menu</span>
            <MenuIcon v-if="!mobileMenuOpen" class="block h-6 w-6" />
            <XIcon v-else class="block h-6 w-6" />
          </button>
        </div>
      </div>
    </div>

    <!-- Mobile menu -->
    <div v-if="mobileMenuOpen" class="sm:hidden">
      <div class="pt-2 pb-3 space-y-1">
        <a
          href="#"
          class="bg-primary-50 border-primary-500 text-primary-700 block pl-3 pr-4 py-2 border-l-4 text-base font-medium"
        >
          Dashboard
        </a>
        <a
          href="#"
          class="border-transparent text-gray-600 hover:bg-gray-50 hover:border-gray-300 hover:text-gray-800 block pl-3 pr-4 py-2 border-l-4 text-base font-medium"
        >
          Events
        </a>

        <!-- Mobile Resources Dropdown -->
        <div>
          <button
            @click="toggleMobileDropdown('resources')"
            class="border-transparent text-gray-600 hover:bg-gray-50 hover:border-gray-300 hover:text-gray-800 block pl-3 pr-4 py-2 border-l-4 text-base font-medium flex justify-between items-center w-full"
          >
            <span>Resources</span>
            <ChevronDownIcon
              class="h-5 w-5"
              :class="{ 'transform rotate-180': mobileDropdowns.resources }"
            />
          </button>
          <div
            v-if="mobileDropdowns.resources"
            class="pl-6 pr-4 py-2 space-y-2"
          >
            <a href="#" class="block py-2 text-sm text-gray-700">
              <span class="inline-block w-6 text-center mr-2">📄</span>
              Documents & Policies
            </a>
            <a href="#" class="block py-2 text-sm text-gray-700">
              <span class="inline-block w-6 text-center mr-2">📊</span>
              Reports & Publications
            </a>
            <a href="#" class="block py-2 text-sm text-gray-700">
              <span class="inline-block w-6 text-center mr-2">💡</span> Guides &
              Toolkits
            </a>
            <a href="#" class="block py-2 text-sm text-gray-700">
              <span class="inline-block w-6 text-center mr-2">🎥</span> Media
              Library
            </a>
            <a href="#" class="block py-2 text-sm text-gray-700">
              <span class="inline-block w-6 text-center mr-2">🎙</span> Press
              Releases
            </a>
            <a href="#" class="block py-2 text-sm text-gray-700">
              <span class="inline-block w-6 text-center mr-2">📝</span> Forms &
              Applications
            </a>
          </div>
        </div>

        <a
          href="#"
          class="border-transparent text-gray-600 hover:bg-gray-50 hover:border-gray-300 hover:text-gray-800 block pl-3 pr-4 py-2 border-l-4 text-base font-medium"
        >
          Community
        </a>
      </div>
      <div class="pt-4 pb-3 border-t border-gray-200">
        <div class="flex items-center px-4">
          <div class="flex-shrink-0">
            <img
              class="h-10 w-10 rounded-full"
              src="https://randomuser.me/api/portraits/men/1.jpg"
              alt="User profile"
            />
          </div>
          <div class="ml-3">
            <div class="text-base font-medium text-gray-800">
              {{ $page.props.auth.user.name }}
            </div>
            <div class="text-sm font-medium text-gray-500">
              {{ $page.props.auth.user.mobile_number }}
            </div>
          </div>
          <button
            class="ml-auto bg-white flex-shrink-0 p-1 rounded-full text-gray-400 hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500"
          >
            <span class="sr-only">View notifications</span>
            <BellIcon class="h-6 w-6" />
          </button>
        </div>
        <div class="mt-3 space-y-1">
          <Link
            href="/profile"
            class="block px-4 py-2 text-base font-medium text-gray-500 hover:text-gray-800 hover:bg-gray-100"
          >
            Your Profile
          </Link>
          <a
            href="#"
            class="block px-4 py-2 text-base font-medium text-gray-500 hover:text-gray-800 hover:bg-gray-100"
          >
            Settings
          </a>
          <Link
            href="/logout"
            method="POST"
            as="button"
            type="button"
            class="block px-4 py-2 text-base font-medium text-gray-500 hover:text-gray-800 hover:bg-gray-100"
          >
            Sign out
          </Link>
        </div>
      </div>
    </div>
  </nav>
</template>

<script setup>
import { ref, reactive } from "vue";
import ApplicationLogo from "@/Components/ApplicationLogo.vue";
import DropdownLink from "@/Components/DropdownLink.vue";
import NavLink from "@/Components/NavLink.vue";
import { Link } from "@inertiajs/vue3";
import { BellIcon, MenuIcon, XIcon, ChevronDownIcon } from "lucide-vue-next";

const mobileMenuOpen = ref(false);
const profileDropdownOpen = ref(false);

// Desktop dropdowns state - only keeping resources
const dropdowns = reactive({
  resources: false,
});

// Mobile dropdowns state - only keeping resources
const mobileDropdowns = reactive({
  resources: false,
});

// Toggle desktop dropdown
const toggleDropdown = (name) => {
  dropdowns[name] = !dropdowns[name];
};

// Toggle mobile dropdown
const toggleMobileDropdown = (name) => {
  mobileDropdowns[name] = !mobileDropdowns[name];
};
</script>
