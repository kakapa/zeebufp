<template>
  <div
    v-if="show"
    class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center p-4 z-50 !mt-0"
  >
    <div
      class="bg-white rounded-lg shadow-xl max-w-md w-full max-h-[90vh] overflow-y-auto"
    >
      <div class="p-6 border-b">
        <h3 class="text-lg font-semibold">{{ title }}</h3>
        <p class="text-sm text-gray-500">{{ description }}</p>
      </div>
      <div class="p-6 space-y-4">
        <slot name="form"></slot>
        <div class="flex space-x-3 pt-4">
          <button
            @click="$emit('cancel')"
            class="flex-1 px-4 py-2 border border-gray-300 rounded-md hover:bg-gray-50"
          >
            Cancel
          </button>
          <button
            @click="$emit('submit')"
            class="flex-1 px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700"
          >
            {{ submitText }}
          </button>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
defineProps({
  show: Boolean,
  title: {
    type: String,
    default: "Add New Client",
  },
  description: {
    type: String,
    default: "Enter client information to register them in the system.",
  },
  submitText: {
    type: String,
    default: "Submit",
  },
});

defineEmits(["cancel", "submit"]);
</script>
