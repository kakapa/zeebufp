<template>
  <div class="relative bg-gray-900">
    <div class="absolute inset-0">
      <img class="w-full h-full object-cover" :src="image" :alt="title" />
      <div class="absolute inset-0 bg-black opacity-60"></div>
    </div>
    <div
      class="relative max-w-7xl mx-auto py-24 px-4 sm:py-32 sm:px-6 lg:px-8 text-center"
    >
      <h1
        class="text-4xl font-extrabold tracking-tight text-white sm:text-5xl lg:text-6xl"
      >
        {{ title }}
      </h1>
      <p class="mt-6 text-xl text-gray-300 max-w-3xl mx-auto">
        {{ phrase }}
      </p>
    </div>
  </div>
</template>

<script setup>
defineProps({
  title: {
    type: String,
  },
  phrase: {
    type: String,
  },
  image: {
    type: String,
  },
});
</script>
