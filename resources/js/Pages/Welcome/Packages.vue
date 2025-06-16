<template>
  <section id="packages" class="py-20 bg-gray-50">
    <div class="container mx-auto px-4">
      <div class="text-center mb-16">
        <h2 class="text-4xl md:text-5xl font-bold mb-6">
          Our
          <span
            class="bg-gradient-to-r from-purple-500 to-pink-500 text-transparent bg-clip-text"
            >Packages</span
          >
        </h2>
        <p class="text-xl text-gray-600 max-w-3xl mx-auto">
          Choose from our range of funeral packages designed to meet different
          needs and budgets. All packages include our commitment to dignity and
          professional service.
        </p>
      </div>

      <div class="flex space-x-6 overflow-x-auto scrollbar-hide pb-8 pt-8">
        <div
          v-for="pkg in packages"
          :key="pkg.name"
          class="min-w-[280px] max-w-[300px] bg-white rounded-lg shadow-lg p-6 flex-shrink-0 relative transition-all duration-300 hover:shadow-xl text-center"
          :class="pkg.popular ? 'ring-2 ring-orange-500 scale-105' : ''"
        >
          <div
            v-if="pkg.popular"
            class="absolute -top-4 left-1/2 transform -translate-x-1/2"
          >
            <div
              class="bg-orange-500 text-white px-4 py-2 rounded-full text-sm font-semibold flex items-center"
            >
              <svg
                class="h-4 w-4 mr-1"
                fill="none"
                stroke="currentColor"
                stroke-width="2"
                viewBox="0 0 24 24"
                xmlns="http://www.w3.org/2000/svg"
              >
                <path
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"
                ></path>
              </svg>
              Most Popular
            </div>
          </div>

          <div class="text-center">
            <h3 class="text-2xl font-bold text-gray-800">{{ pkg.name }}</h3>
            <div class="mt-4">
              <span class="text-4xl font-bold text-purple-800">{{
                pkg.monthlyContributionNoFloatString
              }}</span>
              <span class="text-gray-600">/month</span>
            </div>
            <p class="text-gray-600 mt-2">{{ pkg.description }}</p>
          </div>

          <ul class="space-y-3 my-6 text-left">
            <li
              v-for="(feature, index) in pkg.featuresArray"
              :key="index"
              class="flex items-center"
            >
              <svg
                class="h-5 w-5 text-green-500 mr-3 flex-shrink-0"
                fill="none"
                stroke="currentColor"
                stroke-width="2"
                viewBox="0 0 24 24"
                xmlns="http://www.w3.org/2000/svg"
              >
                <path
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  d="M5 13l4 4L19 7"
                />
              </svg>
              <span class="text-gray-700">{{ feature }}</span>
            </li>
          </ul>

          <Link
            href="#"
            class="block w-full text-center py-3 px-6 rounded-lg font-semibold text-white transition-colors duration-300"
            :class="
              pkg.popular
                ? 'bg-orange-500 hover:bg-orange-600'
                : 'bg-purple-800 hover:bg-purple-900'
            "
          >
            Choose {{ pkg.name }}
          </Link>
        </div>
      </div>

      <div class="mt-16 text-center">
        <div class="bg-white rounded-lg p-8 max-w-4xl mx-auto shadow-lg">
          <h3 class="text-2xl font-bold mb-4 text-purple-800">
            Important Information
          </h3>
          <div class="grid grid-cols-1 md:grid-cols-2 gap-6 text-left">
            <div>
              <h4 class="font-semibold text-gray-800 mb-2">Waiting Period</h4>
              <p class="text-gray-600">
                No waiting period if you immigrate to us T's and C's
              </p>
            </div>
            <div>
              <h4 class="font-semibold text-gray-800 mb-2">Age Coverage</h4>
              <p class="text-gray-600">We have no age limit for coverage</p>
            </div>
            <div>
              <h4 class="font-semibold text-gray-800 mb-2">
                Addtional services (with costs)
              </h4>
              <p class="text-gray-600">
                Add bus, car, cow, catering at extra monthly costs
              </p>
            </div>
            <div>
              <h4 class="font-semibold text-gray-800 mb-2">Cash Back</h4>
              <p class="text-gray-600">
                Cash back from principal members' plan of R5000
              </p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</template>

<script setup>
const props = defineProps({
  packages: Array,
});
</script>

<style scoped>
.container {
  max-width: 1280px;
}
</style>
