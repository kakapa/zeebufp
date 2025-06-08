<template>
  <td :class="['px-4 py-4 whitespace-nowrap', responsiveClass]">
    <slot></slot>
  </td>
</template>

<script setup>
const props = defineProps({
  responsiveClass: {
    type: String,
    default: "",
  },
});
</script>
