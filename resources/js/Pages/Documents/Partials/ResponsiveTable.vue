<template>
  <BaseTable>
    <TableHeader>
      <TableHeaderCell>Document</TableHeaderCell>
      <TableHeaderCell responsive-class="hidden md:table-cell"
        >Client</TableHeaderCell
      >
      <TableHeaderCell responsive-class="hidden sm:table-cell"
        >Type</TableHeaderCell
      >
      <TableHeaderCell responsive-class="hidden lg:table-cell"
        >Uploaded</TableHeaderCell
      >
      <TableHeaderCell>Status</TableHeaderCell>
      <TableHeaderCell responsive-class="text-right">Actions</TableHeaderCell>
    </TableHeader>

    <TableBody>
      <TableRow v-for="document in documents" :key="document.id">
        <TableCell>
          <div class="flex items-center">
            <div class="flex-shrink-0">
              <File class="h-10 w-10" />
            </div>
            <div class="ml-4">
              <div class="text-sm font-medium text-gray-900">
                {{ document.name }}
              </div>
              <div class="text-sm text-gray-500">
                {{ formatFileSize(document.size) }}
              </div>
              <div class="md:hidden mt-2 space-y-1">
                <div v-if="document.client" class="text-sm">
                  <span class="font-medium text-gray-500">Client:</span>
                  <span class="text-gray-900 ml-1">{{
                    document.client.name
                  }}</span>
                </div>
                <div class="text-sm">
                  <span class="font-medium text-gray-500">Type:</span>
                  <span class="text-blue-800 ml-1">{{ document.type }}</span>
                </div>
                <div class="text-sm">
                  <span class="font-medium text-gray-500">Uploaded:</span>
                  <span class="text-gray-500 ml-1">{{
                    formatDate(document.uploaded_at)
                  }}</span>
                </div>
              </div>
            </div>
          </div>
        </TableCell>

        <TableCell responsive-class="hidden md:table-cell">
          <div v-if="document.client" class="text-sm text-gray-900">
            {{ document.client.name }}
          </div>
          <div v-else class="text-sm text-gray-500">Template</div>
        </TableCell>

        <TableCell responsive-class="hidden sm:table-cell">
          <span
            class="px-2 py-1 text-xs rounded-full bg-blue-100 text-blue-800"
          >
            {{ document.type }}
          </span>
        </TableCell>

        <TableCell responsive-class="hidden lg:table-cell">
          <div class="text-sm text-gray-500">
            {{ formatDate(document.uploaded_at) }}
          </div>
          <div class="text-xs text-gray-400">by {{ document.uploaded_by }}</div>
        </TableCell>

        <TableCell>
          <span
            class="px-2 py-1 text-xs rounded-full"
            :class="statusClass(document.status)"
          >
            {{ document.status }}
          </span>
        </TableCell>

        <TableCell responsive-class="text-right">
          <div class="flex items-center justify-end space-x-3">
            <TableAction
              icon="Eye"
              color="blue"
              @click="emit('preview', document)"
            />
            <TableAction
              icon="Download"
              color="green"
              @click="emit('download', document)"
            />
            <TableAction
              icon="Trash2"
              color="red"
              @click="emit('delete', document)"
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
import { File } from "lucide-vue-next";

const props = defineProps({
  documents: {
    type: Array,
    required: true,
  },
});

const emit = defineEmits(["preview", "download", "delete"]);

const formatDate = (dateString) => {
  // Your date formatting logic
};

const formatFileSize = (bytes) => {
  // Your file size formatting logic
};

const statusClass = (status) => {
  return (
    {
      active: "bg-green-100 text-green-800",
      expired: "bg-red-100 text-red-800",
      pending: "bg-yellow-100 text-yellow-800",
    }[status] || "bg-gray-100 text-gray-800"
  );
};
</script>
