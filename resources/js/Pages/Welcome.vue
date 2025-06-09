<template>
  <Head title="Homepage" />

  <GuestLayout>
    <div>
      <!-- Hero Section -->
      <HeroSlider />

      <!-- About Section -->
      <AboutSection />

      <!-- Services Section -->
      <ServicesSection />

      <!-- Packages Section -->
      <Packages />

      <!-- Contact Section -->
      <Contact />
    </div>
  </GuestLayout>
</template>

<script setup>
import GuestLayout from "@/Layouts/GuestLayout.vue";
import HeroSlider from "./Welcome/HeroSlider.vue";
import AboutSection from "./Welcome/AboutSection.vue";
import ServicesSection from "./Welcome/ServicesSection.vue";
import Contact from "./Welcome/Contact.vue";
import Packages from "./Welcome/Packages.vue";
</script>
