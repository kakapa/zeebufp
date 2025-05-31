<template>
  <Link
    :href="href"
    class="w-full block px-4 py-2 text-sm text-left text-gray-700 hover:bg-gray-100"
    role="menuitem"
  >
    <slot />
  </Link>
</template>

<script setup>
import { Link } from "@inertiajs/vue3";

defineProps({
  href: {
    type: String,
    required: true,
  },
});
</script>
