<template>
  <label class="flex items-center cursor-pointer">
    <div class="relative">
      <input type="checkbox" v-model="model" class="sr-only peer" />
      <div
        class="w-11 h-6 bg-gray-300 rounded-full peer peer-checked:bg-primary-600"
      ></div>
      <div
        class="absolute left-0.5 top-0.5 w-5 h-5 bg-white rounded-full transition peer-checked:translate-x-full"
      ></div>
    </div>
    <span class="ml-3 text-gray-700">{{ label }}</span>
  </label>
</template>

<script setup>
const model = defineModel({
  type: Boolean,
  required: true,
});

defineProps({
  label: {
    type: String,
    default: "Switch",
  },
});
</script>
