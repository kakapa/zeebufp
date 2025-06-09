<template>
  <input
    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
    v-model="model"
    ref="input"
  />
</template>

<script setup>
import { onMounted, ref } from "vue";

const model = defineModel({
  type: String,
  required: false,
});

const input = ref(null);

onMounted(() => {
  if (input.value.hasAttribute("autofocus")) {
    input.value.focus();
  }
});

defineExpose({ focus: () => input.value.focus() });
</script>
