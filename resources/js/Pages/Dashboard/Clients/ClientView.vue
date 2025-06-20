<template>
  <div class="p-6 space-y-4">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
      <InfoRow label="Title" :value="client.title" />
      <InfoRow
        label="Full Name"
        :value="`${client.firstname} ${client.lastname}`"
      />
      <InfoRow label="Email" :value="client.email" />
      <InfoRow label="Phone" :value="client.phone" />
      <InfoRow label="ID Number" :value="client.id_number" />
      <InfoRow label="Gender" :value="client.gender" />
      <InfoRow label="Address" :value="client.address" />
      <InfoRow label="Referral Source" :value="client.referral_source" />
      <div class="col-span-2">
        <InfoRow label="Notes" :value="client.notes" />
      </div>
    </div>

    <div class="pt-4 text-right" v-if="showClose">
      <button
        class="px-4 py-2 border border-gray-300 rounded-md hover:bg-gray-100"
        @click="$emit('close')"
      >
        Close
      </button>
    </div>
  </div>
</template>

<script setup>
import { defineProps, defineEmits } from "vue";

// InfoRow is just a small presentational component to keep things DRY
const InfoRow = {
  props: ["label", "value"],
  template: `
    <div>
      <h4 class="text-sm font-semibold text-gray-500">{{ label }}</h4>
      <p class="text-gray-800">{{ value || '-' }}</p>
    </div>
  `,
};

defineProps({
  client: Object,
  showClose: {
    type: Boolean,
    default: false, // true when used in a modal
  },
});

defineEmits(["close"]);
</script>
