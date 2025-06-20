<template>
  <select
    :id="id"
    class="w-full block mt-1 rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500"
    v-model="model"
  >
    <option value="">Choose {{ label }}</option>
    <option v-for="(value, key) in items" :key="key" :value="key">
      {{ value }}
    </option>
  </select>
</template>

<script setup>
const model = defineModel({
  type: String,
  default: "",
});

defineProps({
  id: {
    type: String,
    required: true,
  },
  items: {
    type: Object,
  },
  label: {
    type: String,
    required: true,
  },
});
</script>
