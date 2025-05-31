<template>
  <footer class="bg-gray-900 text-white">
    <div class="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:px-8">
      <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
        <div class="col-span-1">
          <ApplicationIcon class="h-16 w-auto bg-white p-2 rounded" />
          <p class="mt-4 text-sm text-gray-300">
            Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin
            lacinia erat nec lorem blandit.
          </p>
        </div>

        <div>
          <h3
            class="text-sm font-semibold text-primary-400 tracking-wider uppercase"
          >
            Navigation
          </h3>
          <ul class="mt-4 space-y-4">
            <li>
              <Link href="/" class="text-base text-gray-300 hover:text-white"
                >Home</Link
              >
            </li>
            <li>
              <Link
                href="/about"
                class="text-base text-gray-300 hover:text-white"
                >About</Link
              >
            </li>
            <li>
              <Link
                href="/contact"
                class="text-base text-gray-300 hover:text-white"
                >Contact</Link
              >
            </li>
          </ul>
        </div>

        <div>
          <h3
            class="text-sm font-semibold text-primary-400 tracking-wider uppercase"
          >
            Account
          </h3>
          <ul class="mt-4 space-y-4">
            <li>
              <Link
                href="/login"
                class="text-base text-gray-300 hover:text-white"
                >Login</Link
              >
            </li>
            <li>
              <Link
                href="/register"
                class="text-base text-gray-300 hover:text-white"
                >Register</Link
              >
            </li>
            <li>
              <Link
                href="/dashboard"
                class="text-base text-gray-300 hover:text-white"
                >Dashboard</Link
              >
            </li>
            <li>
              <Link
                href="/profile"
                class="text-base text-gray-300 hover:text-white"
                >Profile</Link
              >
            </li>
          </ul>
        </div>

        <div>
          <h3
            class="text-sm font-semibold text-primary-400 tracking-wider uppercase"
          >
            Connect With Us
          </h3>
          <ul class="mt-4 space-y-4">
            <li class="flex items-center">
              <MapPinIcon class="h-5 w-5 text-primary-400 mr-2" />
              <span class="text-base text-gray-300"
                >456 Ipsum Street, Dolor City</span
              >
            </li>
            <li class="flex items-center">
              <PhoneIcon class="h-5 w-5 text-primary-400 mr-2" />
              <span class="text-base text-gray-300">+123 456 7890</span>
            </li>
            <li class="flex items-center">
              <MailIcon class="h-5 w-5 text-primary-400 mr-2" />
              <span class="text-base text-gray-300">hello@example.com</span>
            </li>
          </ul>
          <div class="mt-8 flex space-x-6">
            <a href="#" class="text-gray-400 hover:text-white">
              <FacebookIcon class="h-6 w-6" />
            </a>
            <a href="#" class="text-gray-400 hover:text-white">
              <TwitterIcon class="h-6 w-6" />
            </a>
            <a href="#" class="text-gray-400 hover:text-white">
              <InstagramIcon class="h-6 w-6" />
            </a>
          </div>
        </div>
      </div>

      <div class="mt-12 border-t border-gray-700 pt-8">
        <p class="text-base text-gray-400 text-center">
          &copy; {{ new Date().getFullYear() }} Lorem Ipsum Org. All rights
          reserved.
        </p>
      </div>
    </div>
  </footer>
</template>

<script setup>
import {
  MapPinIcon,
  PhoneIcon,
  MailIcon,
  FacebookIcon,
  TwitterIcon,
  InstagramIcon,
} from "lucide-vue-next";
import { Link } from "@inertiajs/vue3";
import ApplicationIcon from "@/Components/ApplicationIcon.vue";
</script>
