<template>
  <button
    @click="$emit('click', $event)"
    :class="buttonClasses"
    :title="title || icon"
    type="button"
  >
    <component :is="dynamicIcon" class="h-5 w-5" />
  </button>
</template>

<script setup>
import { computed } from "vue";
import * as lucideIcons from "lucide-vue-next";

const props = defineProps({
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
  title: {
    type: String,
    default: "",
  },
});

const emit = defineEmits(["click"]);

const dynamicIcon = computed(() => lucideIcons[props.icon]);

const buttonClasses = computed(() => {
  const base =
    "p-1 rounded-md transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2";
  const colorMap = {
    blue: "text-blue-600 hover:text-blue-900 focus:ring-blue-500",
    green: "text-green-600 hover:text-green-900 focus:ring-green-500",
    red: "text-red-600 hover:text-red-900 focus:ring-red-500",
    gray: "text-gray-600 hover:text-gray-900 focus:ring-gray-500",
    yellow: "text-yellow-600 hover:text-yellow-900 focus:ring-yellow-500",
    indigo: "text-indigo-600 hover:text-indigo-900 focus:ring-indigo-500",
    purple: "text-purple-600 hover:text-purple-900 focus:ring-purple-500",
  };
  return `${base} ${colorMap[props.color] || colorMap.blue}`;
});
</script>
