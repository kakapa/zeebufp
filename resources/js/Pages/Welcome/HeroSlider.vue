<template>
  <section id="home" class="relative min-h-screen pt-40 pb-10 overflow-hidden">
    <!-- Background Slider -->
    <div class="absolute inset-0">
      <div
        v-for="(slide, index) in slides"
        :key="index"
        :class="`absolute inset-0 transition-opacity duration-1000 ${
          index === currentSlide ? 'opacity-100' : 'opacity-0'
        }`"
      >
        <img
          :src="slide.image"
          :alt="slide.title"
          class="w-full h-full object-cover"
        />
        <div
          class="absolute inset-0 bg-gradient-to-r from-black/70 via-black/50 to-transparent"
        ></div>
      </div>
    </div>

    <!-- Curved Overlay -->
    <div class="absolute inset-0 pointer-events-none">
      <svg
        class="absolute bottom-0 w-full h-32"
        viewBox="0 0 1200 120"
        preserveAspectRatio="none"
      >
        <path
          d="M0,0V46.29c47.79,22.2,103.59,32.17,158,28,70.36-5.37,136.33-33.31,206.8-37.5C438.64,32.43,512.34,53.67,583,72.05c69.27,18,138.3,24.88,209.4,13.08,36.15-6,69.85-17.84,104.45-29.34C989.49,25,1113-14.29,1200,52.47V0Z"
          opacity="0.3"
          fill="#7B2D8E"
        />
        <path
          d="M0,0V15.81C13,36.92,27.64,56.86,47.69,72.05,99.41,111.27,165,111,224.58,91.58c31.15-10.15,60.09-26.07,89.67-39.8,40.92-19,84.73-46,130.83-49.67,36.26-2.85,70.9,9.42,98.6,31.56,31.77,25.39,62.32,62,103.63,73,40.44,10.79,81.35-6.69,119.13-24.28s75.16-39,116.92-43.05c59.73-5.85,113.28,22.88,168.9,38.84,30.2,8.66,59,6.17,87.09-7.5,22.43-10.89,48-26.93,60.65-49.24V0Z"
          opacity="0.5"
          fill="#F97316"
        />
      </svg>
    </div>

    <div class="container mx-auto px-4 relative z-10">
      <div class="min-h-screen flex items-center">
        <div class="grid lg:grid-cols-2 gap-16 items-center w-full">
          <!-- Left Content -->
          <div class="space-y-8 text-white animate-fade-in">
            <!-- Main Heading -->
            <div class="space-y-6">
              <h1
                class="text-4xl sm:text-5xl md:text-6xl lg:text-7xl font-bold leading-tight"
              >
                {{ slides[currentSlide].title }}
              </h1>

              <p class="text-2xl font-dancing text-brand-gold">
                {{ slides[currentSlide].subtitle }}
              </p>

              <p class="text-lg md:text-xl leading-relaxed max-w-xl opacity-90">
                {{ slides[currentSlide].description }}
              </p>
            </div>

            <!-- Trust indicators -->
            <div class="flex flex-wrap items-center gap-4 sm:gap-8 py-4">
              <div class="flex items-center space-x-2">
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
                  class="text-brand-gold"
                >
                  <path
                    d="M19 14c1.49-1.46 3-3.21 3-5.5A5.5 5.5 0 0 0 16.5 3c-1.76 0-3 .5-4.5 2-1.5-1.5-2.74-2-4.5-2A5.5 5.5 0 0 0 2 8.5c0 2.3 1.5 4.05 3 5.5l7 7Z"
                  ></path>
                </svg>
                <span class="font-medium">Compassionate Care</span>
              </div>
              <div class="flex items-center space-x-2">
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
                  class="text-brand-gold"
                >
                  <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path>
                </svg>
                <span class="font-medium">Trusted Service</span>
              </div>
              <div class="flex items-center space-x-2">
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
                  class="text-brand-gold"
                >
                  <path
                    d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"
                  ></path>
                </svg>
                <span class="font-medium">24/7 Support</span>
              </div>
            </div>

            <!-- CTA Buttons -->
            <div class="flex flex-col sm:flex-row gap-4 pt-4">
              <a
                href="tel:0836532025"
                class="inline-flex items-center justify-center bg-brand-gold hover:bg-yellow-600 text-black px-8 py-4 text-lg font-semibold shadow-lg hover:shadow-xl transition-all duration-300 rounded-lg"
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
                  class="mr-2"
                >
                  <path
                    d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"
                  ></path>
                </svg>
                Call 083 653 2025
              </a>
              <Link
                href="#about"
                class="inline-flex items-center justify-center border-2 border-white text-white hover:bg-white hover:text-black px-8 py-4 text-lg font-semibold transition-all duration-300 rounded-lg"
              >
                Learn More
              </Link>
            </div>

            <!-- Contact info -->
            <div class="pt-8 border-t border-white/20">
              <p class="text-white/80 mb-2 font-dancing text-lg">
                Need immediate assistance?
              </p>
              <p class="text-3xl font-bold text-brand-gold">083 653 2025</p>
              <p class="text-white/70">Available 24 hours, 7 days a week</p>
            </div>
          </div>

          <!-- Right Content - Stats Card -->
          <div class="space-y-6 animate-slide-in">
            <div
              class="bg-white/10 backdrop-blur-md rounded-2xl p-6 sm:p-8 border border-white/20"
            >
              <div class="text-center space-y-6">
                <h3 class="text-2xl sm:text-3xl font-bold text-white mb-6">
                  Your grief is our concern
                </h3>

                <div class="grid grid-cols-3 gap-4 sm:gap-6 text-center">
                  <div class="space-y-2">
                    <div class="text-3xl sm:text-4xl font-bold text-brand-gold">
                      10+
                    </div>
                    <div class="text-white/80 text-sm">Years Experience</div>
                  </div>
                  <div class="space-y-2">
                    <div class="text-3xl sm:text-4xl font-bold text-brand-gold">
                      500+
                    </div>
                    <div class="text-white/80 text-sm">Families Served</div>
                  </div>
                  <div class="space-y-2">
                    <div class="text-3xl sm:text-4xl font-bold text-brand-gold">
                      R49
                    </div>
                    <div class="text-white/80 text-sm">From/Month</div>
                  </div>
                </div>

                <div class="pt-6 border-t border-white/20">
                  <p class="text-white/90 text-sm leading-relaxed">
                    We offer comprehensive funeral services with both local and
                    international options. Our caring and professional staff
                    provide offerings services and end-to-end commitment.
                  </p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Slide Indicators -->
    <div
      class="absolute bottom-8 left-1/2 transform -translate-x-1/2 flex space-x-2 z-20"
    >
      <button
        v-for="(_, index) in slides"
        :key="index"
        @click="setCurrentSlide(index)"
        :class="`w-3 h-3 rounded-full transition-colors duration-300 ${
          index === currentSlide ? 'bg-brand-gold' : 'bg-white/50'
        }`"
      />
    </div>
  </section>
</template>

<script setup>
import { ref, onMounted, onBeforeUnmount } from "vue";
import { Link } from "@inertiajs/vue3";

const slides = [
  {
    image: "/images/slide1.jpg?ixlib=rb-4.0.3&auto=format&fit=crop&w=1920&q=80",
    title: "Dignity Without Limits",
    subtitle: "Compassionate care for your loved ones",
    description:
      "We provide dignified funeral services that honor the memory of your loved ones with respect and compassion.",
  },
  {
    image: "/images/slide2.jpg?ixlib=rb-4.0.3&auto=format&fit=crop&w=1920&q=80",
    title: "Memorial Services",
    subtitle: "Celebrating lives with honor",
    description:
      "Our memorial services are designed to celebrate the unique life and legacy of your loved one.",
  },
  {
    image: "/images/slide3.jpg?ixlib=rb-4.0.3&auto=format&fit=crop&w=1920&q=80",
    title: "Affordable Care",
    subtitle: "Starting from R49 per month",
    description:
      "Quality funeral services that don't compromise on dignity, with packages designed to fit every budget.",
  },
];

const currentSlide = ref(0);
let timer = null;

const setCurrentSlide = (index) => {
  currentSlide.value = index;
};

onMounted(() => {
  timer = setInterval(() => {
    currentSlide.value = (currentSlide.value + 1) % slides.length;
  }, 5000);
});

onBeforeUnmount(() => {
  clearInterval(timer);
});
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

/* Custom font */
.font-dancing {
  font-family: "Dancing Script", cursive;
}

/* Brand colors */
.text-brand-gold {
  color: #d69e2e;
}
.bg-brand-gold {
  background-color: #d69e2e;
}
</style>
