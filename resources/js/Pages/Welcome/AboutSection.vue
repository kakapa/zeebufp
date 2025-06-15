<template>
  <section id="about" class="py-20 bg-white relative">
    <!-- Curved top divider -->
    <div class="absolute top-0 left-0 right-0 h-16 overflow-hidden">
      <svg
        class="absolute bottom-0 w-full h-16"
        viewBox="0 0 1200 120"
        preserveAspectRatio="none"
      >
        <path
          d="M0,0V46.29c47.79,22.2,103.59,32.17,158,28,70.36-5.37,136.33-33.31,206.8-37.5C438.64,32.43,512.34,53.67,583,72.05c69.27,18,138.3,24.88,209.4,13.08,36.15-6,69.85-17.84,104.45-29.34C989.49,25,1113-14.29,1200,52.47V0Z"
          fill="#7B2D8E"
          opacity="0.1"
        />
      </svg>
    </div>

    <div class="container mx-auto px-4 pt-16">
      <div class="grid lg:grid-cols-2 gap-8 md:gap-16 items-center">
        <!-- Left - Image -->
        <div class="relative animate-fade-in">
          <div class="rounded-2xl overflow-hidden shadow-2xl">
            <img
              src="/images/about.jpg?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80"
              alt="Zeebundelwa Funeral Home Building"
              class="w-full h-[400px] sm:h-[500px] object-cover"
            />
          </div>

          <!-- Floating card -->
          <div
            class="absolute -bottom-4 sm:-bottom-8 -right-4 sm:-right-8 bg-brand-purple text-white p-4 sm:p-6 rounded-xl shadow-xl"
          >
            <div class="text-center">
              <div class="text-2xl sm:text-3xl font-bold text-brand-gold">
                24/7
              </div>
              <div class="text-xs sm:text-sm">Support Available</div>
            </div>
          </div>
        </div>

        <!-- Right - Content -->
        <div class="space-y-6 md:space-y-8 animate-slide-in">
          <div class="space-y-3 md:space-y-4">
            <h2
              class="text-3xl sm:text-4xl lg:text-5xl font-bold text-gray-900"
            >
              Your grief is our concern
            </h2>

            <p class="text-lg sm:text-xl text-gray-600 leading-relaxed">
              For years, we have provided professional, reliable caring, along
              with transportation for both alive and our beloved who have passed
              away. We are passionate about our work.
            </p>

            <p class="text-base sm:text-lg text-gray-600 leading-relaxed">
              We can guarantee about all our commitments and services. Our team
              would be our team will take care of it all. We are here for you
              24/7.
            </p>
          </div>

          <!-- Features -->
          <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 md:gap-6">
            <div class="space-y-2">
              <div
                class="w-10 h-10 sm:w-12 sm:h-12 bg-brand-gold rounded-lg flex items-center justify-center"
              >
                <span class="text-white font-bold text-lg sm:text-xl">✓</span>
              </div>
              <h4 class="font-semibold text-gray-900 text-base sm:text-lg">
                Professional Service
              </h4>
              <p class="text-xs sm:text-sm text-gray-600">
                Experienced and caring staff
              </p>
            </div>

            <div class="space-y-2">
              <div
                class="w-10 h-10 sm:w-12 sm:h-12 bg-brand-orange rounded-lg flex items-center justify-center"
              >
                <span class="text-white font-bold text-lg sm:text-xl">✓</span>
              </div>
              <h4 class="font-semibold text-gray-900 text-base sm:text-lg">
                Transportation
              </h4>
              <p class="text-xs sm:text-sm text-gray-600">Luxury vehicles</p>
            </div>

            <div class="space-y-2">
              <div
                class="w-10 h-10 sm:w-12 sm:h-12 bg-brand-purple rounded-lg flex items-center justify-center"
              >
                <span class="text-white font-bold text-lg sm:text-xl">✓</span>
              </div>
              <h4 class="font-semibold text-gray-900 text-base sm:text-lg">
                Affordable Packages
              </h4>
              <p class="text-xs sm:text-sm text-gray-600">
                Starting from R49/month
              </p>
            </div>

            <div class="space-y-2">
              <div
                class="w-10 h-10 sm:w-12 sm:h-12 bg-brand-gold rounded-lg flex items-center justify-center"
              >
                <span class="text-white font-bold text-lg sm:text-xl">✓</span>
              </div>
              <h4 class="font-semibold text-gray-900 text-base sm:text-lg">
                24/7 Support
              </h4>
              <p class="text-xs sm:text-sm text-gray-600">
                Always here when needed
              </p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</template>

<script setup>
import { Link } from "@inertiajs/vue3";
</script>

<style>
/* Animation styles */
.animate-fade-in {
  animation: fadeIn 1s ease-in-out;
}

.animate-slide-in {
  animation: slideIn 1s ease-in-out;
}

@keyframes fadeIn {
  from {
    opacity: 0;
  }
  to {
    opacity: 1;
  }
}

@keyframes slideIn {
  from {
    opacity: 0;
    transform: translateX(50px);
  }
  to {
    opacity: 1;
    transform: translateX(0);
  }
}

/* Brand colors */
.bg-brand-purple {
  background-color: #7b2d8e;
}
.bg-brand-gold {
  background-color: #d69e2e;
}
.bg-brand-orange {
  background-color: #f97316;
}
.text-brand-gold {
  color: #d69e2e;
}
</style>
