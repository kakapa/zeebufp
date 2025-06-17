<template>
  <BaseTable>
    <TableHeader>
      <TableHeaderCell>Client</TableHeaderCell>
      <TableHeaderCell>Amount</TableHeaderCell>
      <TableHeaderCell>Status</TableHeaderCell>
      <TableHeaderCell>Type</TableHeaderCell>
      <TableHeaderCell>Submitted</TableHeaderCell>
      <TableHeaderCell responsive-class="text-right">Actions</TableHeaderCell>
    </TableHeader>

    <TableBody>
      <TableRow v-for="claim in filteredClaims" :key="claim.id">
        <TableCell>
          <div class="text-sm font-medium text-gray-900">
            {{ claim.clientName || "N/A" }}
          </div>
          <div class="text-sm text-gray-500">
            {{ claim.clientId || "" }}
          </div>
        </TableCell>

        <TableCell>
          <div class="text-sm text-gray-900">
            {{ claim.amountString }}
          </div>
        </TableCell>

        <TableCell>
          <span
            class="px-2 py-1 text-xs rounded-full"
            :class="statusClass(claim.status)"
          >
            {{ claim.statusLabel }}
          </span>
        </TableCell>

        <TableCell>
          <div class="text-sm text-gray-900">
            {{ claim.typeLabel }}
          </div>
        </TableCell>

        <TableCell>
          <div class="text-sm text-gray-500">
            {{ claim.submissionAt }}
          </div>
        </TableCell>

        <TableCell responsive-class="text-right">
          <div class="flex items-center justify-end space-x-3">
            <TableAction
              icon="Eye"
              color="blue"
              @click="$emit('view', claim)"
            />
            <TableAction
              icon="Edit"
              color="green"
              @click="$emit('edit', claim)"
            />
            <TableAction
              icon="Trash2"
              color="red"
              @click="$emit('delete', claim)"
            />
          </div>
        </TableCell>
      </TableRow>
    </TableBody>
  </BaseTable>
</template>

<script setup>
import {
  BaseTable,
  TableHeader,
  TableHeaderCell,
  TableBody,
  TableRow,
  TableCell,
  TableAction,
} from "@/Components/Table";

import { computed } from "vue";

const props = defineProps({
  claims: Array,
  filters: {
    type: Object,
    default: () => ({}),
  },
});

const emit = defineEmits(["view", "edit", "delete"]);

const filteredClaims = computed(() => {
  const term = props.filters.search?.toLowerCase() || "";
  return props.claims.filter((claim) => {
    const searchFields = [
      claim.client?.firstname,
      claim.client?.surname,
      claim.client?.id_number,
      claim.type,
      claim.status,
      claim.slug,
    ]
      .filter(Boolean)
      .join(" ")
      .toLowerCase();
    return searchFields.includes(term);
  });
});

const statusClass = (status) => {
  return (
    {
      pending: "bg-yellow-100 text-yellow-800",
      approved: "bg-green-100 text-green-800",
      rejected: "bg-red-100 text-red-800",
      processing: "bg-primary-100 text-primary-800",
    }[status] || "bg-gray-100 text-gray-800"
  );
};

const formatDate = (dateStr) => {
  if (!dateStr) return "";
  return new Date(dateStr).toLocaleDateString();
};
</script>
