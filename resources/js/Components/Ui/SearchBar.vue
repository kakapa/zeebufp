<template>
  <div class="flex-1 max-w-xs sm:max-w-md mx-2 sm:mx-4 hidden sm:block">
    <div class="relative">
      <Search
        class="absolute left-2 sm:left-3 top-1/2 transform -translate-y-1/2 text-gray-400 h-3 w-3 sm:h-4 sm:w-4"
      />
      <input
        type="text"
        :placeholder="placeholder"
        :value="modelValue"
        @input="$emit('update:modelValue', $event.target.value)"
        class="border border-gray-300 rounded-md pl-8 sm:pl-10 pr-2 sm:pr-4 py-1.5 sm:py-2 w-full text-sm focus:outline-none focus:ring-1 focus:ring-primary-500 focus:border-primary-500"
      />
    </div>
  </div>
</template>

<script setup>
import { Search } from "lucide-vue-next";

defineProps({
  modelValue: String,
  placeholder: {
    type: String,
    default: "Search...",
  },
});

defineEmits(["update:modelValue"]);
</script>
