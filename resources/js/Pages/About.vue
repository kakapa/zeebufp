<template>
  <Head title="About" />

  <GuestLayout>
    <div>
      <!-- Hero Section -->
      <SecondaryHero
        title="About us"
        phrase="Lorem ipsum dolor sit amet, consectetur adipiscing elit."
        image="https://placehold.co/1920x1080?text=1920x1080 Image"
      />

      <!-- History Section -->
      <div class="bg-white py-16 sm:py-24">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
          <div class="lg:text-center">
            <h2
              class="text-base text-primary-500 font-semibold tracking-wide uppercase"
            >
              Our History
            </h2>
            <p
              class="mt-2 text-3xl leading-8 font-extrabold tracking-tight text-gray-900 sm:text-4xl"
            >
              A Legacy of Impact
            </p>
          </div>
          <div class="mt-12 grid grid-cols-1 gap-8 lg:grid-cols-2">
            <div>
              <p class="text-lg text-gray-500">
                Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla
                quam velit, vulputate eu pharetra nec, mattis ac neque.
              </p>
              <p class="mt-4 text-lg text-gray-500">
                Duis vulputate commodo lectus, ac blandit elit tincidunt id. Sed
                rhoncus, tortor sed eleifend tristique.
              </p>
            </div>
            <div>
              <p class="text-lg text-gray-500">
                Vivamus lacinia odio vitae vestibulum. Cras venenatis euismod
                malesuada. Nullam ac erat ante.
              </p>
              <p class="mt-4 text-lg text-gray-500">
                Curabitur sit amet mauris morbi in dui quis est pulvinar
                ullamcorper. Nulla facilisi. Integer lacinia sollicitudin massa.
              </p>
            </div>
          </div>
        </div>
      </div>

      <!-- Vision & Mission -->
      <div class="bg-gray-100 py-16 sm:py-24">
        <div
          class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 grid grid-cols-1 gap-8 lg:grid-cols-2"
        >
          <div class="bg-white p-8 rounded-lg shadow">
            <div
              class="flex items-center justify-center h-16 w-16 rounded-md bg-primary-500 text-white mb-6"
            >
              <EyeIcon class="h-8 w-8" />
            </div>
            <h3 class="text-2xl font-bold text-gray-900 mb-4">Our Vision</h3>
            <p class="text-lg text-gray-500">
              Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed sit
              amet facilisis urna.
            </p>
            <p class="mt-4 text-lg text-gray-500">
              Etiam eget ligula eu lectus lobortis condimentum. Aliquam nonummy
              auctor massa.
            </p>
          </div>
          <div class="bg-white p-8 rounded-lg shadow">
            <div
              class="flex items-center justify-center h-16 w-16 rounded-md bg-primary-500 text-white mb-6"
            >
              <TargetIcon class="h-8 w-8" />
            </div>
            <h3 class="text-2xl font-bold text-gray-900 mb-4">Our Mission</h3>
            <p class="text-lg text-gray-500">
              Donec sit amet eros. Lorem ipsum dolor sit amet, consectetuer
              adipiscing elit.
            </p>
            <p class="mt-4 text-lg text-gray-500">
              Mauris fermentum dictum magna. Sed laoreet aliquam leo. Ut tellus
              dolor, dapibus eget.
            </p>
          </div>
        </div>
      </div>

      <!-- Values Section -->
      <div class="bg-white py-16 sm:py-24">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
          <div class="lg:text-center">
            <h2
              class="text-base text-primary-500 font-semibold tracking-wide uppercase"
            >
              Our Values
            </h2>
            <p
              class="mt-2 text-3xl leading-8 font-extrabold tracking-tight text-gray-900 sm:text-4xl"
            >
              Guiding Principles
            </p>
          </div>
          <div
            class="mt-12 grid grid-cols-1 gap-8 md:grid-cols-2 lg:grid-cols-4"
          >
            <div class="bg-gray-50 p-6 rounded-lg text-center">
              <div
                class="flex items-center justify-center h-12 w-12 rounded-full bg-primary-500 text-white mx-auto"
              >
                <UsersIcon class="h-6 w-6" />
              </div>
              <h3 class="mt-5 text-lg font-medium text-gray-900">Community</h3>
              <p class="mt-2 text-base text-gray-500">
                Praesent dapibus, neque id cursus faucibus, tortor neque egestas
                auguae.
              </p>
            </div>
            <div class="bg-gray-50 p-6 rounded-lg text-center">
              <div
                class="flex items-center justify-center h-12 w-12 rounded-full bg-primary-500 text-white mx-auto"
              >
                <ScaleIcon class="h-6 w-6" />
              </div>
              <h3 class="mt-5 text-lg font-medium text-gray-900">Justice</h3>
              <p class="mt-2 text-base text-gray-500">
                Donec nec justo eget felis facilisis fermentum. Aliquam
                porttitor mauris sit amet.
              </p>
            </div>
            <div class="bg-gray-50 p-6 rounded-lg text-center">
              <div
                class="flex items-center justify-center h-12 w-12 rounded-full bg-primary-500 text-white mx-auto"
              >
                <HandshakeIcon class="h-6 w-6" />
              </div>
              <h3 class="mt-5 text-lg font-medium text-gray-900">
                Accountability
              </h3>
              <p class="mt-2 text-base text-gray-500">
                Morbi in dui quis est pulvinar ullamcorper. Nulla facilisi.
              </p>
            </div>
            <div class="bg-gray-50 p-6 rounded-lg text-center">
              <div
                class="flex items-center justify-center h-12 w-12 rounded-full bg-primary-500 text-white mx-auto"
              >
                <LightbulbIcon class="h-6 w-6" />
              </div>
              <h3 class="mt-5 text-lg font-medium text-gray-900">Innovation</h3>
              <p class="mt-2 text-base text-gray-500">
                Phasellus ultrices nulla quis nibh. Quisque a lectus. Donec
                consectetuer ligula.
              </p>
            </div>
          </div>
        </div>
      </div>

      <!-- Leadership Section -->
      <div class="bg-gray-100 py-16 sm:py-24">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
          <div class="lg:text-center">
            <h2
              class="text-base text-primary-500 font-semibold tracking-wide uppercase"
            >
              Our Leadership
            </h2>
            <p
              class="mt-2 text-3xl font-extrabold tracking-tight text-gray-900 sm:text-4xl"
            >
              Meet the Team
            </p>
          </div>
          <div
            class="mt-12 grid grid-cols-1 gap-8 sm:grid-cols-2 lg:grid-cols-3"
          >
            <div
              v-for="(leader, index) in leaders"
              :key="index"
              class="bg-white overflow-hidden shadow rounded-lg"
            >
              <div class="h-64 w-full bg-gray-200">
                <img
                  :src="leader.image"
                  alt="Leader"
                  class="h-full w-full object-cover"
                />
              </div>
              <div class="p-6 text-center">
                <h3 class="text-xl font-semibold text-gray-900">
                  {{ leader.name }}
                </h3>
                <p class="text-primary-500 font-medium">
                  {{ leader.position }}
                </p>
                <p class="mt-3 text-base text-gray-500">{{ leader.bio }}</p>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- CTA Section -->
      <div class="bg-primary-500">
        <div
          class="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:py-16 lg:px-8 lg:flex lg:items-center lg:justify-between"
        >
          <h2
            class="text-3xl font-extrabold tracking-tight text-white sm:text-4xl"
          >
            <span class="block">Want to be part of our journey?</span>
            <span class="block text-black">Join us today.</span>
          </h2>
          <div class="mt-8 flex lg:mt-0 lg:flex-shrink-0">
            <div class="inline-flex rounded-md shadow">
              <Link
                href="/register"
                class="inline-flex items-center justify-center px-5 py-3 border border-transparent text-base font-medium rounded-md text-primary-600 bg-white hover:bg-gray-100"
              >
                Become a Member
              </Link>
            </div>
            <div class="ml-3 inline-flex rounded-md shadow">
              <Link
                href="/contact"
                class="inline-flex items-center justify-center px-5 py-3 border border-transparent text-base font-medium rounded-md text-white bg-black hover:bg-gray-900"
              >
                Contact Us
              </Link>
            </div>
          </div>
        </div>
      </div>
    </div>
  </GuestLayout>
</template>

<script setup>
import { ref } from "vue";
import GuestLayout from "@/Layouts/GuestLayout.vue";
import {
  EyeIcon,
  TargetIcon,
  UsersIcon,
  ScaleIcon,
  HandshakeIcon,
  LightbulbIcon,
} from "lucide-vue-next";
import SecondaryHero from "@/Components/Ui/SecondaryHero.vue";

const leaders = ref([
  {
    name: "John Doe",
    position: "President",
    bio: "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer nec odio. Praesent libero. Sed cursus ante dapibus diam.",
    image: "https://placehold.co/300x300?text=President",
  },
  {
    name: "Jane Smith",
    position: "Secretary General",
    bio: "Suspendisse potenti. Morbi in dui quis est pulvinar ullamcorper. Nulla facilisi. Integer lacinia sollicitudin massa.",
    image: "https://placehold.co/300x300?text=Secretary",
  },
  {
    name: "Michael Johnson",
    position: "Treasurer",
    bio: "Fusce nec tellus sed augue semper porta. Mauris massa. Vestibulum lacinia arcu eget nulla.",
    image: "https://placehold.co/300x300?text=Treasurer",
  },
]);
</script>
