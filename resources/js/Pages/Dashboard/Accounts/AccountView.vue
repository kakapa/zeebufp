<template>
  <div class="p-2 space-y-4">
    <div class="flex flex-col gap-4">
      <InfoRow label="Account ID" :value="account.slug" />
      <InfoRow label="Package" :value="account.mainPackage.name || 'N/A'" />

      <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div>
          <InfoRow label="Client Name" :value="account.clientName" />
          <InfoRow label="Client Phone" :value="account.clientPhone" />
        </div>

        <div>
          <InfoRow
            label="Total Coverage"
            :value="account.totalCoverageAmountString"
          />
          <InfoSlot label="Status">
            <span
              class="px-2 py-1 text-xs rounded-full"
              :class="statusClass(account.status)"
            >
              {{ account.statusLabel }}
            </span>
          </InfoSlot>
        </div>
      </div>

      <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div>
          <InfoRow label="Payday" :value="`${account.payday} of every month`" />
          <InfoRow
            label="Last Payment"
            :value="account.lastPaymentAt || 'N/A'"
          />
        </div>

        <div>
          <InfoRow
            label="Total Monthly"
            :value="account.totalContributionAmountString"
          />
          <InfoRow
            label="Next Payment"
            :value="account.nextPaymentAt || 'N/A'"
          />
        </div>
      </div>

      <!-- Beneficiaries Accordion Section -->
      <div class="pt-2">
        <h3 class="text-lg font-medium text-gray-900 mb-2">Beneficiaries</h3>
        <div class="space-y-2">
          <div
            v-for="(beneficiary, index) in account.beneficiaries"
            :key="beneficiary.id"
            class="border rounded-md"
          >
            <button
              @click="toggleAccordion(index)"
              class="flex items-center justify-between w-full p-3 text-left hover:bg-gray-50"
            >
              <div class="flex items-center space-x-3">
                <span class="font-medium">{{ beneficiary.fullName }}</span>
                <span class="text-sm text-gray-500">{{
                  beneficiary.relationshipLabel
                }}</span>
              </div>
              <svg
                class="w-5 h-5 text-gray-500 transition-transform duration-200"
                :class="{ 'rotate-180': openAccordion === index }"
                fill="none"
                viewBox="0 0 24 24"
                stroke="currentColor"
              >
                <path
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  stroke-width="2"
                  d="M19 9l-7 7-7-7"
                />
              </svg>
            </button>
            <div v-show="openAccordion === index" class="p-3 pt-0 border-t">
              <div class="grid grid-cols-1 md:grid-cols-2 gap-3 text-sm">
                <div>
                  <p class="text-gray-500">Gender</p>
                  <p>{{ beneficiary.genderLabel }}</p>
                </div>
                <div>
                  <p class="text-gray-500">ID Number</p>
                  <p>{{ beneficiary.id_number || "N/A" }}</p>
                </div>
                <div>
                  <p class="text-gray-500">Phone</p>
                  <p>{{ beneficiary.phone || "N/A" }}</p>
                </div>
                <div>
                  <p class="text-gray-500">Added On</p>
                  <p>{{ beneficiary.createdAt || "N/A" }}</p>
                </div>
              </div>
              <div class="mt-3 flex justify-end">
                <SecondaryButton
                  @click.stop="deleteBeneficiary(beneficiary.id)"
                  class="text-red-600 hover:text-red-800 text-sm font-medium flex items-center gap-1"
                >
                  <svg
                    xmlns="http://www.w3.org/2000/svg"
                    class="h-4 w-4"
                    viewBox="0 0 20 20"
                    fill="currentColor"
                  >
                    <path
                      fill-rule="evenodd"
                      d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z"
                      clip-rule="evenodd"
                    />
                  </svg>
                  Delete Beneficiary
                </SecondaryButton>
              </div>
            </div>
          </div>
          <p
            v-if="account.beneficiaries.length === 0"
            class="text-sm text-gray-500"
          >
            No beneficiaries listed
          </p>
        </div>
      </div>

      <!-- PDF Download Section -->
      <div class="pt-2">
        <InfoSlot label="Contract">
          <button
            @click="downloadPdf(account.id)"
            class="flex items-center gap-2 text-primary-600 hover:text-primary-800 hover:underline"
          >
            <svg
              xmlns="http://www.w3.org/2000/svg"
              class="h-5 w-5"
              viewBox="0 0 20 20"
              fill="currentColor"
            >
              <path
                fill-rule="evenodd"
                d="M3 17a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm3.293-7.707a1 1 0 011.414 0L9 10.586V3a1 1 0 112 0v7.586l1.293-1.293a1 1 0 111.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z"
                clip-rule="evenodd"
              />
            </svg>
            Download Contract PDF
          </button>
        </InfoSlot>
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
import { ref } from "vue";
import { router } from "@inertiajs/vue3";
import InfoRow from "@/Components/Ui/InfoRow.vue";
import InfoSlot from "@/Components/Ui/InfoSlot.vue";
import { useToast } from "vue-toast-notification";
import SecondaryButton from "@/Components/Ui/SecondaryButton.vue";

defineProps({
  account: Object,
  showClose: {
    type: Boolean,
    default: false,
  },
});

defineEmits(["close"]);

const openAccordion = ref(null);
const toast = useToast();

const toggleAccordion = (index) => {
  openAccordion.value = openAccordion.value === index ? null : index;
};

const statusClass = (status) => {
  return (
    {
      active: "bg-green-100 text-green-800",
      pending: "bg-yellow-100 text-yellow-800",
      inactive: "bg-red-100 text-red-800",
    }[status] || "bg-gray-100 text-gray-800"
  );
};

const downloadPdf = (id) => {
  const url = route("accounts.pdf", id);
  window.open(url, "_blank");
};

const deleteBeneficiary = (beneficiaryId) => {
  if (
    !confirm(
      "Are you sure you want to delete this beneficiary? This action cannot be undone."
    )
  ) {
    return;
  }

  router.delete(route("beneficiaries.destroy", beneficiaryId), {
    preserveScroll: true,
    onSuccess: () => {
      toast.success("Beneficiary deleted successfully", {
        position: "top-right",
        duration: 3000,
      });
      // Remove the beneficiary from the account's beneficiaries list
      const index = account.beneficiaries.findIndex(
        (b) => b.id === beneficiaryId
      );
      if (index !== -1) {
        account.beneficiaries.splice(index, 1);
      }
    },
    onError: () => {
      // Optional: Show error message
      toast.error("Failed to delete beneficiary", {
        position: "top-right",
        duration: 3000,
      });
    },
  });
};
</script>
