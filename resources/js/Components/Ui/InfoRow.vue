<template>
  <div>
    <h4 class="text-sm font-semibold text-gray-500">{{ label }}</h4>
    <p class="text-gray-800">{{ value }}</p>
  </div>
</template>

<script setup>
defineProps({
  label: {
    type: String,
    required: true,
  },
  value: {
    type: String,
    default: "N/A",
  },
});
</script>
