<template>
  <button
    class="flex items-center gap-2 px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition-colors"
  >
    <Plus class="h-4 w-4" />
    <slot />
  </button>
</template>

<script setup>
import { Plus } from "lucide-vue-next";
</script>
