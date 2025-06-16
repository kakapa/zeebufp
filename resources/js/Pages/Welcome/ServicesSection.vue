<template>
  <section id="services" class="py-20 bg-gray-50 relative">
    <div class="container mx-auto px-4">
      <!-- Heading -->
      <div class="text-center mb-16 animate-fade-in">
        <h2 class="text-4xl lg:text-5xl font-bold text-gray-900 mb-6">
          Our Services
        </h2>
        <p class="text-xl text-gray-600 max-w-3xl mx-auto">
          We provide comprehensive funeral services to help you honor your loved
          ones with dignity and respect.
        </p>
      </div>

      <!-- Services Grid -->
      <div
        class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-5 gap-6"
      >
        <div
          v-for="(service, index) in services"
          :key="index"
          class="group relative overflow-hidden rounded-xl shadow-lg hover:shadow-2xl transition-all duration-500 transform hover:scale-105 animate-fade-in"
          :style="{ animationDelay: `${index * 100}ms` }"
        >
          <div class="aspect-square relative">
            <img
              :src="service.image"
              :alt="service.title"
              class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110"
            />
            <div
              class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/40 to-transparent"
            ></div>
            <div class="absolute bottom-0 left-0 right-0 p-6 text-white">
              <h3 class="text-xl font-bold mb-2">{{ service.title }}</h3>
              <p
                class="text-sm opacity-90 transform translate-y-4 group-hover:translate-y-0 transition-transform duration-300"
              >
                {{ service.description }}
              </p>
            </div>
          </div>
        </div>
      </div>

      <!-- Call to Action -->
      <div class="text-center mt-12">
        <Link
          href="#contact"
          class="bg-yellow-400 hover:bg-yellow-500 text-black px-8 py-3 rounded-lg font-semibold transition-colors duration-300"
        >
          Talk to us
        </Link>
      </div>
    </div>
  </section>
</template>

<script setup>
import { Link } from "@inertiajs/vue3";

const services = [
  {
    title: "Funeral Services",
    image:
      "/images/service_funeral.jpg?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80",
    description: "Complete funeral arrangements with dignity and respect",
  },
  {
    title: "Flowers",
    image:
      "/images/service_flowers.jpg?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80",
    description: "Beautiful floral arrangements for your loved ones",
  },
  {
    title: "Graveside Decor",
    image:
      "/images/service_decor.jpg?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80",
    description: "Elegant graveside decorations and memorials",
  },
  {
    title: "Luxury Vehicles",
    image:
      "/images/service_cars.jpg?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80",
    description: "Premium transportation for funeral services",
  },
  {
    title: "Other Services",
    image:
      "/images/service_catering.jpg?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80",
    description: "We may offer addtional services according to your needs",
  },
];
</script>

<style scoped>
@keyframes fade-in {
  from {
    opacity: 0;
    transform: translateY(20px);
  }
  to {
    opacity: 1;
    transform: translateY(0);
  }
}
.animate-fade-in {
  animation: fade-in 0.6s ease-out both;
}
</style>
