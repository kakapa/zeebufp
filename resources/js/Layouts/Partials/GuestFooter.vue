<template>
  <footer class="bg-gray-900 text-white py-12">
    <div class="container mx-auto px-4">
      <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
        <!-- Logo & About -->
        <div class="md:col-span-2">
          <div class="mb-6">
            <ApplicationIcon class="h-12 w-12" />
          </div>
          <p class="text-gray-300 mb-4 leading-relaxed">
            Zeebundelwa Funeral Home provides compassionate and dignified
            funeral services to families in their time of need. Our commitment
            to "Dignity without limits" ensures every family receives the care
            and respect they deserve.
          </p>
          <div class="flex items-center space-x-4 text-gray-300">
            <Phone />
            <span class="font-semibold">083 653 2025</span>
          </div>
        </div>

        <!-- Quick Links -->
        <div>
          <h3 class="text-lg font-semibold mb-4">Quick Links</h3>
          <ul class="space-y-2">
            <li>
              <Link
                href="#home"
                class="text-gray-300 hover:text-white transition-colors"
                >Home</Link
              >
            </li>
            <li>
              <Link
                href="#services"
                class="text-gray-300 hover:text-white transition-colors"
                >Services</Link
              >
            </li>
            <li>
              <Link
                href="#packages"
                class="text-gray-300 hover:text-white transition-colors"
                >Packages</Link
              >
            </li>
            <li>
              <Link
                href="#about"
                class="text-gray-300 hover:text-white transition-colors"
                >About</Link
              >
            </li>
            <li>
              <Link
                href="#contact"
                class="text-gray-300 hover:text-white transition-colors"
                >Contact</Link
              >
            </li>
            <li>
              <Link
                href="/login"
                class="text-gray-300 hover:text-white transition-colors"
                >Login</Link
              >
            </li>
          </ul>
        </div>

        <!-- Packages Summary -->
        <div>
          <h3 class="text-lg font-semibold mb-4">Our Packages</h3>
          <ul class="space-y-2 text-gray-300">
            <li>Basic - R49/month</li>
            <li>Standard - R79/month</li>
            <li>Premium - R129/month</li>
            <li>Executive - R199/month</li>
            <li>Extended Family - R299/month</li>
          </ul>
          <p class="text-sm text-gray-400 mt-4">
            Children under 18 are FREE under parent's cover
          </p>
        </div>
      </div>

      <!-- Footer Bottom -->
      <div class="border-t border-gray-800 mt-8 pt-8">
        <div class="flex flex-col md:flex-row justify-between items-center">
          <div class="flex items-center mb-4 md:mb-0 text-gray-300">
            <svg
              class="h-5 w-5 text-red-500 mr-2"
              fill="none"
              stroke="currentColor"
              stroke-width="2"
              viewBox="0 0 24 24"
            >
              <path
                d="M12 21C12 21 4 13.3636 4 8.90909C4 6.3496 6.1496 4.2 8.70909 4.2C10.0818 4.2 11.3636 4.92727 12 6.07273C12.6364 4.92727 13.9182 4.2 15.2909 4.2C17.8504 4.2 20 6.3496 20 8.90909C20 13.3636 12 21 12 21Z"
              />
            </svg>
            <span>Made with care for our community</span>
          </div>
          <div class="text-gray-400 text-sm text-center md:text-right">
            © 2024 Zeebundelwa Funeral Home. All rights reserved.
          </div>
        </div>
      </div>
    </div>
  </footer>
</template>

<script setup>
import ApplicationIcon from "@/Components/Ui/ApplicationIcon.vue";
import { Link } from "@inertiajs/vue3";
import { Phone } from "lucide-vue-next";
</script>

<style scoped>
/* Add custom styles here if needed */
</style>
