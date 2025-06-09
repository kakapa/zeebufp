<template>
  <Link :href="href" class="text-primary hover:text-gray-600">
    {{ text }}
  </Link>
</template>

<script setup>
import { Link } from "@inertiajs/vue3";

defineProps({
  href: {
    type: String,
    required: true,
  },
  text: {
    type: String,
    required: true,
  },
});
</script>
