<template>
  <Head title="Homepage" />

  <GuestLayout>
    <div>
      <!-- Hero Section -->
      <PrimaryHero />

      <!-- Mission Section -->
      <section class="bg-white py-16 sm:py-24">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
          <div class="lg:text-center">
            <h2
              class="text-base text-primary-500 font-semibold tracking-wide uppercase"
            >
              Our Mission
            </h2>
            <p class="mt-2 text-3xl font-extrabold text-gray-900 sm:text-4xl">
              Lorem Ipsum Dolor Sit Amet
            </p>
            <p class="mt-4 max-w-2xl text-xl text-gray-500 lg:mx-auto">
              Lorem ipsum dolor sit amet, consectetur adipiscing elit. Quisque
              vel urna quis sapien efficitur ultrices.
            </p>
          </div>

          <div class="mt-16 grid grid-cols-1 gap-8 md:grid-cols-3">
            <div class="bg-gray-50 p-6 rounded-lg">
              <div
                class="flex items-center justify-center h-12 w-12 rounded-md bg-primary-500 text-white"
              >
                <HomeIcon class="h-6 w-6" />
              </div>
              <h3 class="mt-5 text-lg font-medium text-gray-900">
                Housing & Infrastructure
              </h3>
              <p class="mt-2 text-base text-gray-500">
                Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer
                posuere erat a ante.
              </p>
            </div>

            <div class="bg-gray-50 p-6 rounded-lg">
              <div
                class="flex items-center justify-center h-12 w-12 rounded-md bg-green-600 text-white"
              >
                <BookOpenIcon class="h-6 w-6" />
              </div>
              <h3 class="mt-5 text-lg font-medium text-gray-900">
                Education & Youth
              </h3>
              <p class="mt-2 text-base text-gray-500">
                Cras justo odio, dapibus ac facilisis in, egestas eget quam.
                Vestibulum id ligula porta felis.
              </p>
            </div>

            <div class="bg-gray-50 p-6 rounded-lg">
              <div
                class="flex items-center justify-center h-12 w-12 rounded-md bg-red-600 text-white"
              >
                <HeartHandshakeIcon class="h-6 w-6" />
              </div>
              <h3 class="mt-5 text-lg font-medium text-gray-900">
                Community Safety
              </h3>
              <p class="mt-2 text-base text-gray-500">
                Donec sed odio dui. Etiam porta sem malesuada magna mollis
                euismod.
              </p>
            </div>
          </div>
        </div>
      </section>

      <!-- News & Events Section -->
      <section class="bg-gray-100 py-16 sm:py-24">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
          <div class="lg:text-center mb-12">
            <h2
              class="text-base text-primary-500 font-semibold tracking-wide uppercase"
            >
              Stay Informed
            </h2>
            <p class="mt-2 text-3xl font-extrabold text-gray-900 sm:text-4xl">
              Latest News & Events
            </p>
          </div>

          <div class="grid grid-cols-1 gap-8 md:grid-cols-2 lg:grid-cols-3">
            <div
              v-for="index in 3"
              :key="index"
              class="bg-white shadow rounded-lg overflow-hidden"
            >
              <div class="h-48 w-full bg-gray-200">
                <img
                  src="https://placehold.co/600x300"
                  alt="News image"
                  class="h-full w-full object-cover"
                />
              </div>
              <div class="p-6">
                <div class="flex items-center">
                  <CalendarIcon class="h-5 w-5 text-primary-500" />
                  <span class="ml-2 text-sm text-gray-500">April 18, 2025</span>
                </div>
                <h3 class="mt-2 text-xl font-semibold text-gray-900">
                  Lorem Ipsum News Title
                </h3>
                <p class="mt-3 text-base text-gray-500">
                  Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla
                  vitae elit libero, a pharetra augue.
                </p>
                <div class="mt-4">
                  <a
                    href="#"
                    class="text-primary-500 hover:text-primary-600 font-medium"
                    >Read more →</a
                  >
                </div>
              </div>
            </div>
          </div>

          <div class="mt-12 text-center">
            <Link
              href="/news"
              class="inline-flex items-center px-4 py-2 text-base font-medium rounded-md text-primary-500 bg-white hover:bg-gray-50"
            >
              View All News & Events
            </Link>
          </div>
        </div>
      </section>

      <!-- Testimonials Section -->
      <section class="bg-white py-16 sm:py-24">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
          <div class="lg:text-center mb-12">
            <h2
              class="text-base text-primary-500 font-semibold tracking-wide uppercase"
            >
              Testimonials
            </h2>
            <p class="mt-2 text-3xl font-extrabold text-gray-900 sm:text-4xl">
              What People Are Saying
            </p>
          </div>

          <div class="mt-12 grid gap-8 lg:grid-cols-3">
            <div
              v-for="index in 3"
              :key="index"
              class="bg-gray-50 p-6 rounded-lg"
            >
              <div class="flex items-center mb-4">
                <div class="h-12 w-12 rounded-full overflow-hidden bg-gray-300">
                  <img
                    src="https://placehold.co/100"
                    alt="Avatar"
                    class="h-full w-full object-cover"
                  />
                </div>
                <div class="ml-4">
                  <h4 class="text-lg font-medium text-gray-900">Jane Doe</h4>
                  <p class="text-sm text-gray-500">Community Member</p>
                </div>
              </div>
              <p class="text-gray-600 italic">
                “Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                Integer posuere erat a ante.”
              </p>
            </div>
          </div>
        </div>
      </section>

      <!-- CTA Section -->
      <section class="bg-primary-500">
        <div
          class="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:py-16 lg:px-8 flex flex-col lg:flex-row items-center justify-between"
        >
          <h2
            class="text-3xl font-extrabold text-white sm:text-4xl text-center lg:text-left"
          >
            <span>Ready to make a difference?</span>
            <br />
            <span class="text-black">Join Us Today</span>
          </h2>
          <div class="mt-8 flex flex-col sm:flex-row lg:mt-0 lg:flex-shrink-0">
            <Link
              href="/register"
              class="inline-flex items-center justify-center px-5 py-3 border border-transparent text-base font-medium rounded-md text-primary-600 bg-white hover:bg-gray-100"
            >
              Become a Member
            </Link>
            <Link
              href="/contact"
              class="mt-3 sm:mt-0 sm:ml-3 inline-flex items-center justify-center px-5 py-3 border border-transparent text-base font-medium rounded-md text-white bg-black hover:bg-gray-900"
            >
              Contact Us
            </Link>
          </div>
        </div>
      </section>
    </div>
  </GuestLayout>
</template>

<script setup>
import {
  HomeIcon,
  BookOpenIcon,
  HeartHandshakeIcon,
  CalendarIcon,
} from "lucide-vue-next";
import GuestLayout from "@/Layouts/GuestLayout.vue";
import PrimaryHero from "@/Components/PrimaryHero.vue";
</script>
