<template>
  <div class="p-2 space-y-4">
    <div class="flex flex-col gap-4">
      <InfoRow label="Full Name" :value="`${client.fullName}`" />
      <InfoRow label="Email" :value="client.email" />
      <InfoRow label="Phone" :value="client.phone" />
      <InfoRow label="ID Number" :value="client.id_number" />
      <InfoRow label="Gender" :value="client.genderLabel" />
      <InfoRow label="Address" :value="client.address" />
      <InfoRow label="Referral Source" :value="client.referralSourceLabel" />
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
import InfoRow from "@/Components/Ui/InfoRow.vue";

defineProps({
  client: Object,
  showClose: {
    type: Boolean,
    default: false,
  },
});

defineEmits(["close"]);
</script>
