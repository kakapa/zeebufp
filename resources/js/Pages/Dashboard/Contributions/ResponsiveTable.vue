<template>
  <BaseTable>
    <TableHeader>
      <TableHeaderCell>Reference</TableHeaderCell>
      <TableHeaderCell>Amount</TableHeaderCell>
      <TableHeaderCell>Type</TableHeaderCell>
      <TableHeaderCell>Method</TableHeaderCell>
      <TableHeaderCell>Status</TableHeaderCell>
      <TableHeaderCell responsive-class="hidden md:table-cell">
        Pay At
      </TableHeaderCell>
      <TableHeaderCell responsive-class="text-right">Actions</TableHeaderCell>
    </TableHeader>

    <TableBody>
      <TableRow v-for="contribution in contributions" :key="contribution.id">
        <TableCell>
          <div class="text-sm font-medium text-gray-900">
            {{ contribution.slug }}
          </div>
          <div v-if="contribution.accountId" class="text-xs text-gray-500">
            {{ contribution.accountId }}
          </div>
          <div v-if="contribution.clientName" class="text-xs text-gray-500">
            {{ contribution.clientName }}
          </div>
        </TableCell>

        <TableCell>
          <div class="text-sm text-gray-900">
            R {{ parseFloat(contribution.amount).toFixed(2) }}
          </div>
        </TableCell>

        <TableCell>
          <span class="text-sm text-gray-700">
            {{ contribution.typeLabel }}
          </span>
        </TableCell>

        <TableCell>
          <span class="text-sm text-gray-700">
            {{ contribution.methodLabel }}
          </span>
        </TableCell>

        <TableCell>
          <span
            class="px-2 py-1 text-xs rounded-full"
            :class="statusClass(contribution.status)"
          >
            {{ contribution.statusLabel }}
          </span>
        </TableCell>

        <TableCell responsive-class="hidden md:table-cell">
          <span class="text-sm text-gray-600">
            {{ contribution.createdAt }}
          </span>
        </TableCell>

        <TableCell responsive-class="text-right">
          <div class="flex justify-end space-x-3">
            <TableAction
              icon="Eye"
              color="blue"
              @click="$emit('view', contribution)"
            />
            <TableAction
              icon="Edit"
              color="green"
              @click="$emit('edit', contribution)"
            />
            <TableAction
              icon="Trash2"
              color="red"
              @click="$emit('delete', contribution)"
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

const props = defineProps({
  contributions: {
    type: Array,
    required: true,
  },
});

const emit = defineEmits(["view", "edit", "delete"]);
const statusClass = (status) => {
  return (
    {
      paid: "bg-green-100 text-green-800",
      pending: "bg-yellow-100 text-yellow-800",
      failed: "bg-red-100 text-red-800",
    }[status] || "bg-gray-100 text-gray-800"
  );
};
</script>
