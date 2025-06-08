<template>
  <th
    :class="[
      'px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider sticky top-0 bg-gray-50 z-20',
      responsiveClass,
    ]"
    :scope="scope"
  >
    <slot></slot>
  </th>
</template>

<script setup>
const props = defineProps({
  scope: {
    type: String,
    default: "col",
  },
  responsiveClass: {
    type: String,
    default: "",
  },
});
</script>
