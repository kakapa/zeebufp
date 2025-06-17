<template>
  <BaseTable>
    <TableHeader>
      <TableHeaderCell>Client</TableHeaderCell>
      <TableHeaderCell responsive-class="hidden md:table-cell"
        >Contact</TableHeaderCell
      >
      <TableHeaderCell responsive-class="hidden sm:table-cell"
        >ID Number</TableHeaderCell
      >
      <TableHeaderCell>Status</TableHeaderCell>
      <TableHeaderCell responsive-class="text-right">Actions</TableHeaderCell>
    </TableHeader>

    <TableBody>
      <TableRow v-for="client in filteredClients" :key="client.id">
        <TableCell>
          <div class="flex items-center">
            <div class="flex-shrink-0">
              <div
                class="h-10 w-10 rounded-full bg-primary-100 flex items-center justify-center"
              >
                <span class="text-primary-600 font-medium">{{
                  client.initials
                }}</span>
              </div>
            </div>
            <div class="ml-4">
              <div class="text-sm font-medium text-gray-900">
                {{ client.fullName }}
              </div>
              <div class="md:hidden mt-2 space-y-1">
                <div class="text-sm">
                  <span class="font-medium text-gray-500">Contact:</span>
                  <span class="text-gray-900 ml-1">{{
                    client.phone || "N/A"
                  }}</span>
                </div>
                <div class="text-sm">
                  <span class="font-medium text-gray-500">ID:</span>
                  <span class="text-gray-900 ml-1">{{
                    client.id_number || "N/A"
                  }}</span>
                </div>
              </div>
            </div>
          </div>
        </TableCell>

        <TableCell responsive-class="hidden md:table-cell">
          <div class="text-sm text-gray-900">
            {{ client.phone || "N/A" }}
          </div>
          <div class="text-sm text-gray-500">
            {{ client.email || "N/A" }}
          </div>
        </TableCell>

        <TableCell responsive-class="hidden sm:table-cell">
          <div class="text-sm text-gray-900">
            {{ client.id_number || "N/A" }}
          </div>
          <div class="text-xs text-gray-500">
            {{ client.gender ? client.genderLabel : "" }}
          </div>
        </TableCell>

        <TableCell>
          <span
            class="px-2 py-1 text-xs rounded-full"
            :class="statusClass(client.status)"
          >
            {{ client.statusLabel }}
          </span>
        </TableCell>

        <TableCell responsive-class="text-right">
          <div class="flex items-center justify-end space-x-3">
            <TableAction
              icon="Eye"
              color="blue"
              @click="showClientModal = true"
            />
            <TableAction
              icon="Edit"
              color="green"
              @click="$emit('edit', client)"
            />
            <TableAction
              icon="Trash2"
              color="red"
              @click="$emit('delete', client)"
            />
          </div>
        </TableCell>
      </TableRow>
    </TableBody>
  </BaseTable>
</template>

<script setup>
import { computed } from "vue";
import {
  BaseTable,
  TableHeader,
  TableHeaderCell,
  TableBody,
  TableRow,
  TableCell,
  TableAction,
} from "@/Components/Table";
import ClientView from "./ClientView.vue";

const props = defineProps({
  clients: {
    type: Array,
    required: true,
  },
  filters: {
    type: Object,
    default: () => ({}),
  },
});

const emit = defineEmits(["view", "edit", "delete"]);

const filteredClients = computed(() => {
  const term = props.filters.search?.toLowerCase() || "";
  return props.clients
    .filter((client) => {
      const searchFields = [
        client.firstname,
        client.surname,
        client.middlename,
        client.email,
        client.id_number,
        client.phone,
      ]
        .filter(Boolean)
        .join(" ")
        .toLowerCase();

      return searchFields.includes(term);
    })
    .map((client) => ({
      ...client,
      initials: getInitials(client),
      full_name: getFullName(client),
    }));
});

const getInitials = (client) => {
  return `${client.firstname.charAt(0)}${client.surname.charAt(
    0
  )}`.toUpperCase();
};

const getFullName = (client) => {
  const parts = [client.titleLabel, client.firstname, client.surname].filter(
    Boolean
  );
  return parts.join(" ");
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
</script>
