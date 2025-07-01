<template>
  <div class="space-y-4">
    <div>
      <label class="block text-sm font-medium text-gray-700"> Account </label>
      <input
        type="text"
        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
        :value="selectedAccountForPackage ? selectedAccountForPackage.slug : ''"
        disabled
      />
    </div>

    <div>
      <label class="block text-sm font-medium text-gray-700">
        Additional Packages *
      </label>
      <div class="mt-2 space-y-2">
        <div
          v-for="pkg in addtionalPackages"
          :key="pkg.id"
          class="flex items-start"
        >
          <div class="flex h-5 items-center">
            <input
              :id="`package-${pkg.id}`"
              v-model="packageForm.selected_packages"
              type="checkbox"
              :value="pkg.id"
              class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500"
            />
          </div>
          <div class="ml-3 text-sm">
            <label :for="`package-${pkg.id}`" class="font-medium text-gray-700">
              {{ pkg.name }}
            </label>
            <p class="text-gray-500">{{ pkg.features }}</p>
            <p class="text-sm font-semibold text-indigo-600">
              {{ pkg.monthlyContributionNoFloatString }}
            </p>
          </div>
        </div>
      </div>
      <p
        class="mt-1 text-sm text-red-600"
        v-if="packageForm.errors.selected_packages"
      >
        {{ packageForm.errors.selected_packages }}
      </p>
    </div>
  </div>
</template>

<script setup>
defineProps({
  selectedAccountForPackage: {
    type: Object,
    required: true,
  },
  packageForm: {
    type: Object,
    required: true,
  },
  addtionalPackages: {
    type: Object,
    required: true,
  },
});
</script>
