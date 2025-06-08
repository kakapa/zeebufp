<template>
  <label class="block text-sm font-medium text-gray-700 mb-1">
    <span v-if="value">{{ value }}</span>
    <span v-else><slot /></span>
  </label>
</template>

<script setup>
defineProps({
  value: {
    type: String,
  },
});
</script>
