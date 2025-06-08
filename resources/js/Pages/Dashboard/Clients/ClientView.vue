<template>
  <DialogModal
    :show="show"
    :title="`Client Details: ${client.full_name}`"
    max-width="3xl"
    @close="$emit('close')"
  >
    <template #content>
      <div class="space-y-6">
        <!-- Client Header -->
        <div class="flex items-start gap-6">
          <div class="flex-shrink-0">
            <div
              class="h-24 w-24 rounded-full bg-blue-100 flex items-center justify-center"
            >
              <span class="text-blue-600 text-3xl font-bold">
                {{ client.initials }}
              </span>
            </div>
          </div>
          <div class="flex-1">
            <h3 class="text-2xl font-bold text-gray-900">
              {{ client.full_name }}
              <span class="ml-2 text-sm font-normal" :class="statusClass">
                {{ client.statusLabel }}
              </span>
            </h3>
            <p class="text-gray-600 mt-1">{{ client.title?.label() }}</p>

            <div class="mt-4 flex flex-wrap gap-4">
              <div class="flex items-center text-sm text-gray-500">
                <Phone class="h-4 w-4 mr-1.5 text-gray-400" />
                {{ client.phone || "Not provided" }}
              </div>
              <div class="flex items-center text-sm text-gray-500">
                <Mail class="h-4 w-4 mr-1.5 text-gray-400" />
                {{ client.email || "Not provided" }}
              </div>
              <div class="flex items-center text-sm text-gray-500">
                <IdCard class="h-4 w-4 mr-1.5 text-gray-400" />
                {{ client.id_number || "Not provided" }}
              </div>
            </div>
          </div>
        </div>

        <!-- Main Details -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
          <!-- Personal Information -->
          <div class="bg-gray-50 p-4 rounded-lg">
            <h4 class="font-medium text-gray-900 mb-3 flex items-center">
              <User class="h-5 w-5 mr-2 text-gray-500" />
              Personal Information
            </h4>
            <dl class="space-y-3">
              <div class="grid grid-cols-3 gap-4">
                <dt class="text-sm text-gray-500">Gender</dt>
                <dd class="col-span-2 text-sm text-gray-900">
                  {{ client.gender?.label() || "Not specified" }}
                </dd>
              </div>
              <div class="grid grid-cols-3 gap-4">
                <dt class="text-sm text-gray-500">Date of Birth</dt>
                <dd class="col-span-2 text-sm text-gray-900">
                  {{ formatDate(client.date_of_birth) || "Not specified" }}
                </dd>
              </div>
              <div class="grid grid-cols-3 gap-4">
                <dt class="text-sm text-gray-500">ID Number</dt>
                <dd class="col-span-2 text-sm text-gray-900">
                  {{ client.id_number || "Not provided" }}
                </dd>
              </div>
            </dl>
          </div>

          <!-- Contact Information -->
          <div class="bg-gray-50 p-4 rounded-lg">
            <h4 class="font-medium text-gray-900 mb-3 flex items-center">
              <Contact class="h-5 w-5 mr-2 text-gray-500" />
              Contact Information
            </h4>
            <dl class="space-y-3">
              <div class="grid grid-cols-3 gap-4">
                <dt class="text-sm text-gray-500">Phone</dt>
                <dd class="col-span-2 text-sm text-gray-900">
                  {{ client.phone || "Not provided" }}
                </dd>
              </div>
              <div class="grid grid-cols-3 gap-4">
                <dt class="text-sm text-gray-500">Email</dt>
                <dd class="col-span-2 text-sm text-gray-900">
                  {{ client.email || "Not provided" }}
                </dd>
              </div>
              <div class="grid grid-cols-3 gap-4">
                <dt class="text-sm text-gray-500">Address</dt>
                <dd class="col-span-2 text-sm text-gray-900">
                  {{ client.address || "Not provided" }}
                </dd>
              </div>
            </dl>
          </div>

          <!-- Additional Information -->
          <div class="bg-gray-50 p-4 rounded-lg">
            <h4 class="font-medium text-gray-900 mb-3 flex items-center">
              <Info class="h-5 w-5 mr-2 text-gray-500" />
              Additional Information
            </h4>
            <dl class="space-y-3">
              <div class="grid grid-cols-3 gap-4">
                <dt class="text-sm text-gray-500">Referral Source</dt>
                <dd class="col-span-2 text-sm text-gray-900">
                  {{ client.referral_source?.label() || "Not specified" }}
                </dd>
              </div>
              <div class="grid grid-cols-3 gap-4">
                <dt class="text-sm text-gray-500">Registration Date</dt>
                <dd class="col-span-2 text-sm text-gray-900">
                  {{ formatDate(client.created_at) }}
                </dd>
              </div>
              <div class="grid grid-cols-3 gap-4">
                <dt class="text-sm text-gray-500">Last Updated</dt>
                <dd class="col-span-2 text-sm text-gray-900">
                  {{ formatDate(client.updated_at) }}
                </dd>
              </div>
            </dl>
          </div>

          <!-- Notes Section -->
          <div class="bg-gray-50 p-4 rounded-lg md:col-span-2">
            <h4 class="font-medium text-gray-900 mb-3 flex items-center">
              <NotebookText class="h-5 w-5 mr-2 text-gray-500" />
              Notes
            </h4>
            <div class="bg-white p-3 rounded border border-gray-200 min-h-32">
              <p
                v-if="client.notes"
                class="text-sm text-gray-800 whitespace-pre-line"
              >
                {{ client.notes }}
              </p>
              <p v-else class="text-sm text-gray-500 italic">
                No notes available for this client
              </p>
            </div>
          </div>
        </div>
      </div>
    </template>

    <template #footer>
      <SecondaryButton @click="$emit('close')"> Close </SecondaryButton>
      <PrimaryButton class="ml-3" @click="$emit('edit', client)">
        <Edit class="h-4 w-4 mr-2" />
        Edit Client
      </PrimaryButton>
    </template>
  </DialogModal>
</template>

<script setup>
import { computed } from "vue";
import {
  Phone,
  Mail,
  IdCard,
  User,
  Contact,
  Info,
  NotebookText,
  Edit,
} from "lucide-vue-next";
import DialogModal from "@/Components/Ui/DialogModal.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";

const props = defineProps({
  show: {
    type: Boolean,
    default: false,
  },
  client: {
    type: Object,
    required: true,
    default: () => ({}),
  },
});

const emit = defineEmits(["close", "edit"]);

const statusClass = computed(() => {
  return (
    {
      active: "bg-green-100 text-green-800",
      pending: "bg-yellow-100 text-yellow-800",
      inactive: "bg-red-100 text-red-800",
    }[props.client.status] || "bg-gray-100 text-gray-800"
  );
});

const formatDate = (dateString) => {
  if (!dateString) return "";
  const options = { year: "numeric", month: "short", day: "numeric" };
  return new Date(dateString).toLocaleDateString(undefined, options);
};
</script>
