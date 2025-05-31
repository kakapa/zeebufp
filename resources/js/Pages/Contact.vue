<template>
  <Head title="Contact" />

  <GuestLayout>
    <div>
      <!-- Hero Section -->
      <SecondaryHero
        title="Contact us"
        phrase="Get in touch with VILTURA. We're here to listen, assist, and collaborate."
        image="https://placehold.co/1920x1080?text=1920x1080 Image"
      />

      <!-- Contact Form Section -->
      <div class="bg-white py-16 sm:py-24">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
          <div class="grid grid-cols-1 gap-8 lg:grid-cols-2">
            <div>
              <h2 class="text-3xl font-extrabold text-gray-900">
                Get in Touch
              </h2>
              <p class="mt-4 text-lg text-gray-500">
                Have questions, suggestions, or want to get involved with
                VILTURA? Fill out the form below, and one of our team members
                will get back to you as soon as possible.
              </p>

              <div class="mt-8 space-y-6">
                <div class="flex items-center">
                  <MapPinIcon class="h-6 w-6 text-primary-500" />
                  <span class="ml-3 text-base text-gray-500"
                    >42 Artisan Street, Codetown, South Africa</span
                  >
                </div>
                <div class="flex items-center">
                  <PhoneIcon class="h-6 w-6 text-primary-500" />
                  <span class="ml-3 text-base text-gray-500"
                    >+27 87 654 3210</span
                  >
                </div>
                <div class="flex items-center">
                  <MailIcon class="h-6 w-6 text-primary-500" />
                  <span class="ml-3 text-base text-gray-500"
                    >hello@laravelhub.dev</span
                  >
                </div>
                <div class="flex items-center">
                  <ClockIcon class="h-6 w-6 text-primary-500" />
                  <span class="ml-3 text-base text-gray-500"
                    >Monday - Friday: 9:00 AM - 6:00 PM</span
                  >
                </div>
              </div>

              <div class="mt-8">
                <h3 class="text-lg font-medium text-gray-900">Follow Us</h3>
                <div class="mt-4 flex space-x-6">
                  <a href="#" class="text-gray-400 hover:text-primary-500">
                    <FacebookIcon class="h-6 w-6" />
                  </a>
                  <a href="#" class="text-gray-400 hover:text-primary-500">
                    <TwitterIcon class="h-6 w-6" />
                  </a>
                  <a href="#" class="text-gray-400 hover:text-primary-500">
                    <InstagramIcon class="h-6 w-6" />
                  </a>
                  <a href="#" class="text-gray-400 hover:text-primary-500">
                    <YoutubeIcon class="h-6 w-6" />
                  </a>
                </div>
              </div>
            </div>

            <div class="bg-white p-8 rounded-lg shadow-lg">
              <form @submit.prevent="submitForm" class="space-y-6">
                <div>
                  <label
                    for="name"
                    class="block text-sm font-medium text-gray-700"
                    >Full Name</label
                  >
                  <input
                    type="text"
                    id="name"
                    v-model="form.name"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500"
                  />
                </div>
                <div>
                  <label
                    for="email"
                    class="block text-sm font-medium text-gray-700"
                    >Email Address</label
                  >
                  <input
                    type="email"
                    id="email"
                    v-model="form.email"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500"
                  />
                </div>
                <div>
                  <label
                    for="phone"
                    class="block text-sm font-medium text-gray-700"
                    >Phone Number</label
                  >
                  <input
                    type="tel"
                    id="phone"
                    v-model="form.phone"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500"
                  />
                </div>
                <div>
                  <label
                    for="subject"
                    class="block text-sm font-medium text-gray-700"
                    >Subject</label
                  >
                  <input
                    type="text"
                    id="subject"
                    v-model="form.subject"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500"
                  />
                </div>
                <div>
                  <label
                    for="message"
                    class="block text-sm font-medium text-gray-700"
                    >Message</label
                  >
                  <textarea
                    id="message"
                    v-model="form.message"
                    rows="4"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500"
                  ></textarea>
                </div>
                <div>
                  <button
                    type="submit"
                    class="w-full flex justify-center py-3 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-primary-500 hover:bg-primary-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500"
                  >
                    Send Message
                  </button>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>

      <!-- Map Section -->
      <div class="bg-gray-100 py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
          <div class="lg:text-center mb-12">
            <h2 class="text-3xl font-extrabold text-gray-900">Find Us</h2>
            <p class="mt-4 text-lg text-gray-500 max-w-3xl mx-auto">
              Visit our national headquarters or one of our regional offices
              across South Africa.
            </p>
          </div>
          <div class="h-96 w-full bg-gray-300 rounded-lg overflow-hidden">
            <!-- Placeholder for map -->
            <div
              class="h-full w-full flex items-center justify-center bg-gray-200"
            >
              <MapIcon class="h-16 w-16 text-gray-400" />
              <span class="ml-4 text-gray-500 text-lg"
                >Interactive Map Would Be Displayed Here</span
              >
            </div>
          </div>
        </div>
      </div>

      <!-- Regional Offices Section -->
      <div class="bg-white py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
          <div class="lg:text-center mb-12">
            <h2 class="text-3xl font-extrabold text-gray-900">
              Regional Offices
            </h2>
            <p class="mt-4 text-lg text-gray-500 max-w-3xl mx-auto">
              VILTURA has a presence across South Africa. Find the office
              nearest to you.
            </p>
          </div>
          <div class="grid grid-cols-1 gap-8 sm:grid-cols-2 lg:grid-cols-3">
            <div
              v-for="(office, index) in regionalOffices"
              :key="index"
              class="bg-gray-50 p-6 rounded-lg"
            >
              <h3 class="text-lg font-medium text-gray-900">
                {{ office.region }}
              </h3>
              <p class="mt-2 text-base text-gray-500">
                {{ office.address }}
              </p>
              <p class="mt-2 text-base text-gray-500">
                {{ office.phone }}
              </p>
              <p class="mt-2 text-base text-gray-500">
                {{ office.email }}
              </p>
            </div>
          </div>
        </div>
      </div>

      <!-- FAQ Section -->
      <div class="bg-gray-100 py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
          <div class="lg:text-center mb-12">
            <h2 class="text-3xl font-extrabold text-gray-900">
              Frequently Asked Questions
            </h2>
            <p class="mt-4 text-lg text-gray-500 max-w-3xl mx-auto">
              Find answers to common questions about VILTURA and how to get
              involved.
            </p>
          </div>
          <div class="mt-12">
            <div
              v-for="(faq, index) in faqs"
              :key="index"
              class="bg-white p-6 rounded-lg shadow-sm mb-4"
            >
              <button
                @click="faq.isOpen = !faq.isOpen"
                class="flex justify-between items-center w-full text-left"
              >
                <h3 class="text-lg font-medium text-gray-900">
                  {{ faq.question }}
                </h3>
                <ChevronDownIcon
                  :class="[
                    'h-5 w-5 text-gray-500 transition-transform',
                    faq.isOpen ? 'transform rotate-180' : '',
                  ]"
                />
              </button>
              <div v-if="faq.isOpen" class="mt-4 text-base text-gray-500">
                <p>{{ faq.answer }}</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </GuestLayout>
</template>

<script setup>
import { ref, reactive } from "vue";
import GuestLayout from "@/Layouts/GuestLayout.vue";
import {
  MapPinIcon,
  PhoneIcon,
  MailIcon,
  ClockIcon,
  FacebookIcon,
  TwitterIcon,
  InstagramIcon,
  YoutubeIcon,
  MapIcon,
  ChevronDownIcon,
} from "lucide-vue-next";
import SecondaryHero from "@/Components/SecondaryHero.vue";

const form = reactive({
  name: "",
  email: "",
  phone: "",
  subject: "",
  message: "",
});

const submitForm = () => {
  // Form submission logic would go here
  alert("Thank you for your message. We will get back to you soon!");
  // Reset form
  form.name = "";
  form.email = "";
  form.phone = "";
  form.subject = "";
  form.message = "";
};

const regionalOffices = ref([
  {
    region: "Laravel Core",
    address: "100 Artisan Lane, Tinker City, 8000",
    phone: "+27 87 111 2233",
    email: "support@laravelcore.dev",
  },
  {
    region: "Inertia Hub",
    address: "42 SPA Boulevard, Viewtown, 7001",
    phone: "+27 86 432 1010",
    email: "help@inertiahub.dev",
  },
  {
    region: "Breeze Base",
    address: "55 Jetstream Drive, Featherland, 9002",
    phone: "+27 82 222 3344",
    email: "team@breezebase.dev",
  },
  {
    region: "Docker Dock",
    address: "88 Container Street, Compose Bay, 6003",
    phone: "+27 81 345 9876",
    email: "docker@dockerspace.dev",
  },
  {
    region: "VueVille",
    address: "77 Reactive Road, Vuenation, 7100",
    phone: "+27 83 555 6677",
    email: "info@vueville.dev",
  },
  {
    region: "PSR District",
    address: "12 Standard Street, Codestyle City, 8800",
    phone: "+27 85 678 1122",
    email: "psr12@phplint.dev",
  },
]);

const faqs = ref([
  {
    question: "What is Laravel Breeze?",
    answer:
      "Laravel Breeze is a minimal and simple authentication starter kit that uses Blade or Inertia.js with Vue or React for frontend scaffolding.",
    isOpen: false,
  },
  {
    question: "How do I set up user authentication with Breeze?",
    answer:
      "Install Breeze via Composer, run the Breeze install command, and migrate your database. It instantly provides registration, login, password reset, and email verification features.",
    isOpen: false,
  },
  {
    question: "What is Inertia.js and how does it work with Laravel?",
    answer:
      "Inertia.js lets you build modern single-page apps using classic server-side routing with Laravel and a JavaScript framework like Vue 3 — no need for an API.",
    isOpen: false,
  },
  {
    question: "Is Docker recommended for Laravel development?",
    answer:
      "Absolutely. Using Laravel Sail or your own Docker setup allows for consistent local environments, easy onboarding, and smooth CI/CD processes.",
    isOpen: false,
  },
  {
    question: "What does PSR-12 mean for Laravel projects?",
    answer:
      "PSR-12 is a coding style guide. Adopting it in Laravel projects helps maintain clean, consistent, and modern PHP code, especially in team environments.",
    isOpen: false,
  },
]);
</script>
