<template>
  <input
    type="checkbox"
    :value="value"
    v-model="proxyChecked"
    class="h-4 w-4 text-primary-500 focus:ring-primary-500 border-gray-300 rounded"
  />
</template>

<script setup>
import { computed } from "vue";

const emit = defineEmits(["update:checked"]);

const props = defineProps({
  checked: {
    type: [Array, Boolean],
    required: true,
  },
  value: {
    default: null,
  },
});

const proxyChecked = computed({
  get() {
    return props.checked;
  },

  set(val) {
    emit("update:checked", val);
  },
});
</script>
