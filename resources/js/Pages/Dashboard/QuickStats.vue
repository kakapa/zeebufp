<template>
  <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <div
      v-for="(stat, index) in stats"
      :key="index"
      class="bg-white rounded-lg shadow p-6"
    >
      <div class="flex items-center justify-between pb-2">
        <h3 class="text-sm font-medium text-gray-600">
          {{ stat.title }}
        </h3>
        <component :is="stat.icon" class="h-4 w-4 text-gray-400" />
      </div>
      <div>
        <div class="text-2xl font-bold">{{ stat.value }}</div>
        <p class="text-xs text-gray-500">
          <span
            :class="
              stat.change.startsWith('+') ? 'text-green-600' : 'text-red-600'
            "
          >
            {{ stat.change }}
          </span>
          from last month
        </p>
      </div>
    </div>
  </div>
</template>

<script setup>
defineProps({
  stats: Array,
});
</script>
