<template>
  <textarea
    class="rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500"
    v-model="model"
    rows="6"
    ref="input"
  ></textarea>
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
