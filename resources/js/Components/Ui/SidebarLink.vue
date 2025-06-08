<template>
  <Link
    :href="to"
    class="flex items-center px-3 py-2 rounded-lg text-sm font-medium gap-3"
    :class="
      active
        ? 'bg-indigo-100 text-indigo-700'
        : 'text-gray-600 hover:bg-gray-50 hover:text-gray-800'
    "
  >
    <component :is="icon" class="w-4 h-4" />
    <slot />
  </Link>
</template>

<script setup>
defineProps({
  to: String,
  icon: [String, Object],
  active: Boolean,
});
</script>
