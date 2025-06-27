<template>
  <section id="contact" class="py-12 md:py-20 bg-white">
    <div class="container mx-auto px-4">
      <div class="text-center mb-12 md:mb-16">
        <h2 class="text-3xl md:text-4xl lg:text-5xl font-bold mb-4 md:mb-6">
          Contact
          <span
            class="text-transparent bg-clip-text bg-gradient-to-r from-purple-600 to-orange-500"
            >Us</span
          >
        </h2>
        <p class="text-lg md:text-xl text-gray-600 max-w-3xl mx-auto">
          We're here to help you during your time of need. Reach out to us
          anytime for immediate assistance or to learn more about our services.
        </p>
      </div>

      <div class="max-w-6xl mx-auto">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 md:gap-12">
          <!-- Left Column -->
          <div class="space-y-6 md:space-y-8">
            <!-- Emergency Contact Card -->
            <div
              class="bg-gradient-to-br from-purple-800 to-orange-500 text-white rounded-xl shadow-lg overflow-hidden"
            >
              <div class="p-6">
                <h3
                  class="text-xl md:text-2xl font-semibold flex items-center mb-4"
                >
                  <svg
                    xmlns="http://www.w3.org/2000/svg"
                    width="24"
                    height="24"
                    viewBox="0 0 24 24"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="2"
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    class="h-6 w-6 mr-3"
                  >
                    <path
                      d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"
                    ></path>
                  </svg>
                  Emergency Contact
                </h3>
                <div class="text-2xl md:text-3xl font-bold mb-2">
                  {{ $page.props.settings.other_phone }}
                </div>
                <p class="text-white/90 mb-4">
                  Available 24 hours a day, 7 days a week
                </p>
                <a
                  :href="dialablePhoneNumber($page.props.settings.other_phone)"
                  class="inline-flex items-center justify-center bg-white text-purple-800 hover:bg-gray-100 px-6 py-3 rounded-lg font-medium transition-colors"
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
                    class="h-4 w-4 mr-2"
                  >
                    <path
                      d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"
                    ></path>
                  </svg>
                  Call Now
                </a>
              </div>
            </div>

            <!-- Email and Visit Cards -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 md:gap-6">
              <div class="bg-white rounded-lg shadow-md overflow-hidden">
                <div class="p-4 md:p-6 text-center">
                  <svg
                    xmlns="http://www.w3.org/2000/svg"
                    width="32"
                    height="32"
                    viewBox="0 0 24 24"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="2"
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    class="h-8 w-8 text-purple-800 mx-auto mb-3"
                  >
                    <path
                      d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"
                    ></path>
                    <polyline points="22,6 12,13 2,6"></polyline>
                  </svg>
                  <h3 class="font-semibold mb-2 text-base md:text-lg">
                    Email Us
                  </h3>
                  <p class="text-gray-600 text-sm">
                    {{ $page.props.settings.main_email }}
                  </p>
                </div>
              </div>

              <div class="bg-white rounded-lg shadow-md overflow-hidden">
                <div class="p-4 md:p-6 text-center">
                  <svg
                    xmlns="http://www.w3.org/2000/svg"
                    width="32"
                    height="32"
                    viewBox="0 0 24 24"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="2"
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    class="h-8 w-8 text-purple-800 mx-auto mb-3"
                  >
                    <path
                      d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"
                    ></path>
                  </svg>
                  <h3 class="font-semibold mb-2 text-base md:text-lg">
                    Call Us
                  </h3>
                  <p class="text-gray-600 text-sm">
                    {{ $page.props.settings.main_phone }}
                  </p>
                </div>
              </div>
            </div>

            <!-- Business Hours Card -->
            <div class="bg-white rounded-lg shadow-md overflow-hidden">
              <div class="p-6">
                <h3
                  class="flex items-center text-purple-800 font-semibold text-lg md:text-xl mb-4"
                >
                  <svg
                    xmlns="http://www.w3.org/2000/svg"
                    width="20"
                    height="20"
                    viewBox="0 0 24 24"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="2"
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    class="h-5 w-5 mr-2"
                  >
                    <circle cx="12" cy="12" r="10"></circle>
                    <polyline points="12 6 12 12 16 14"></polyline>
                  </svg>
                  Business Hours
                </h3>
                <div class="space-y-2">
                  <div class="flex justify-between">
                    <span class="text-gray-700">Monday - Friday:</span>
                    <span class="font-semibold">8:00 AM - 5:00 PM</span>
                  </div>
                  <div class="flex justify-between">
                    <span class="text-gray-700">Saturday:</span>
                    <span class="font-semibold">8:00 AM - 2:00 PM</span>
                  </div>
                  <div class="flex justify-between">
                    <span class="text-gray-700">Sunday:</span>
                    <span class="font-semibold">Emergency Only</span>
                  </div>
                  <div class="mt-4 pt-4 border-t">
                    <p class="text-sm text-gray-600">
                      <strong>Emergency Line:</strong> Available 24/7 for
                      immediate assistance
                    </p>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- Right Column -->
          <div class="space-y-6 md:space-y-8">
            <!-- Contact Form -->
            <div class="bg-white rounded-lg shadow-md overflow-hidden">
              <div class="p-6">
                <h3
                  class="text-purple-800 font-semibold text-lg md:text-xl mb-6"
                >
                  Get In Touch
                </h3>
                <form
                  @submit.prevent="handleContactForm"
                  class="space-y-4 md:space-y-6"
                >
                  <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2"
                      >Name</label
                    >
                    <input
                      type="text"
                      v-model="form.name"
                      class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-purple-500"
                      placeholder="Your full name"
                    />
                  </div>
                  <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2"
                      >Phone</label
                    >
                    <input
                      type="tel"
                      v-model="form.phone"
                      class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-purple-500"
                      placeholder="Your phone number"
                    />
                  </div>
                  <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2"
                      >Email</label
                    >
                    <input
                      type="email"
                      v-model="form.email"
                      class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-purple-500"
                      placeholder="Your email address"
                    />
                  </div>
                  <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2"
                      >Message</label
                    >
                    <textarea
                      rows="4"
                      v-model="form.message"
                      class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-purple-500"
                      placeholder="How can we help you?"
                    ></textarea>
                  </div>
                  <button
                    type="submit"
                    :class="{
                      disabled: form.processing,
                      'opacity-25': form.processing,
                    }"
                    class="w-full bg-purple-800 hover:bg-purple-900 text-white px-6 py-3 rounded-lg font-medium transition-colors"
                  >
                    Send Message
                  </button>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Full Width Map Section -->
      <div class="mt-12 md:mt-16 w-full">
        <div class="bg-white text-center p-6">
          <h3 class="text-xl md:text-2xl font-semibold text-purple-800 mb-4">
            Our Location
          </h3>
          <address class="not-italic text-gray-700 mb-6">
            <p class="flex items-center justify-center">
              <svg
                xmlns="http://www.w3.org/2000/svg"
                class="h-5 w-5 mr-2 text-purple-600"
                fill="none"
                viewBox="0 0 24 24"
                stroke="currentColor"
              >
                <path
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  stroke-width="2"
                  d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"
                />
                <path
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  stroke-width="2"
                  d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"
                />
              </svg>
              <span>{{ $page.props.settings.main_address }}</span>
            </p>
          </address>

          <!-- Full Width Google Map -->
          <div class="w-full h-96 rounded-lg overflow-hidden shadow-lg">
            <iframe
              src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1ddummy!2d0!3d0!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zMMKwMDAnMDAuMCJOIDDCwDAwJzAwLjAiRQ!5e0!3m2!1sen!2sza!4v1234567890123!5m2!1sen!2sza"
              width="100%"
              height="100%"
              style="border: 0"
              allowfullscreen=""
              loading="lazy"
              referrerpolicy="no-referrer-when-downgrade"
            ></iframe>
          </div>
        </div>
      </div>
    </div>
  </section>
</template>

<script setup>
import { useForm } from "@inertiajs/vue3";
import dialablePhoneNumber from "@/Composables/useUtils";
import { useToast } from "vue-toast-notification";

const form = useForm({
  name: "",
  phone: "",
  email: "",
  message: "",
});

const toast = useToast();

const handleContactForm = () => {
  form.post("/contact", {
    preserveScroll: true,
    onSuccess: () => {
      toast.success("Message sent, thank you contacting us!", {
        position: "top-right",
      });
      form.reset();
    },
  });
};
</script>
