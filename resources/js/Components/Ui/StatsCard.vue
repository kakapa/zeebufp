<template>
  <div class="bg-white rounded-lg shadow p-6">
    <div class="flex items-center justify-between">
      <div>
        <p class="text-sm font-medium text-gray-600">{{ label }}</p>
        <div class="mt-1">
          <p class="text-2xl font-bold">{{ value }}</p>
          <p class="text-sm text-gray-600">{{ description }}</p>
        </div>
      </div>

      <component
        :is="dynamicIcon"
        :class="`h-8 w-8 ${colorMap[color] || colorMap.blue}`"
      />
    </div>
  </div>
</template>

<script setup>
import { computed } from "vue";
import * as lucideIcons from "lucide-vue-next";

const props = defineProps({
  label: {
    type: String,
    default: "Title here",
  },
  value: {
    type: null,
    required: true,
  },
  description: {
    type: String,
    default: "Some description here",
  },
  icon: {
    type: String,
    required: true,
    validator: (value) => value in lucideIcons,
  },
  color: {
    type: String,
    default: "blue",
    validator: (value) =>
      ["blue", "green", "red", "gray", "yellow", "indigo", "purple"].includes(
        value
      ),
  },
});

const dynamicIcon = computed(() => lucideIcons[props.icon]);

const colorMap = {
  blue: "text-blue-600 hover:text-blue-900 focus:ring-blue-500",
  green: "text-green-600 hover:text-green-900 focus:ring-green-500",
  red: "text-red-600 hover:text-red-900 focus:ring-red-500",
  gray: "text-gray-600 hover:text-gray-900 focus:ring-gray-500",
  yellow: "text-yellow-600 hover:text-yellow-900 focus:ring-yellow-500",
  indigo: "text-indigo-600 hover:text-indigo-900 focus:ring-indigo-500",
  purple: "text-purple-600 hover:text-purple-900 focus:ring-purple-500",
};
</script>
