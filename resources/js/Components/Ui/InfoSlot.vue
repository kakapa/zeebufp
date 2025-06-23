<template>
  <div>
    <h4 class="text-sm font-semibold text-gray-500">{{ label }}</h4>
    <slot />
  </div>
</template>

<script setup>
defineProps({
  label: {
    type: String,
    required: true,
  },
});
</script>
