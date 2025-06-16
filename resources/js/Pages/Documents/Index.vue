<template>
  <AuthenticatedLayout>
    <Head title="Document Management" />

    <div class="container mx-auto px-4 py-8 space-y-6">
      <!-- Header and Stats -->
      <div
        class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4"
      >
        <div>
          <h2 class="text-2xl font-bold">Document Management</h2>
          <p class="text-gray-600">
            Manage all documents for clients, accounts, payments, and claims
          </p>
        </div>
        <AddButton @click="showDialog = true"> Add Document </AddButton>
      </div>

      <!-- Document Statistics -->
      <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        <StatsCard
          label="Total Documents"
          icon="File"
          color="blue"
          :value="documents.length"
          description="All documents"
        />

        <StatsCard
          label="Pending Review"
          icon="Clock"
          color="yellow"
          :value="pendingDocumentsCount"
          description="Awaiting approval"
        />

        <StatsCard
          label="Approved"
          icon="CheckCircle"
          color="green"
          :value="approvedDocumentsCount"
          description="Verified documents"
        />

        <StatsCard
          label="Storage Used"
          icon="HardDrive"
          color="indigo"
          :value="formatStorage(totalStorageUsed)"
          description="Total space occupied"
        />
      </div>

      <!-- Filters -->
      <div
        class="bg-white rounded-lg shadow p-6 grid grid-cols-1 md:grid-cols-2 gap-4"
      >
        <div>
          <InputLabel for="types" value="Type" />
          <Select
            id="types"
            label="Type"
            v-model="selectedType"
            :items="types"
            placeholder="Filter by type"
          />
        </div>
        <div>
          <InputLabel for="statuses" value="Status" />
          <Select
            id="statuses"
            label="Status"
            v-model="selectedStatus"
            :items="statuses"
            placeholder="Filter by status"
          />
        </div>
      </div>

      <!-- Search and Filters -->
      <SearchBox
        v-model="searchTerm"
        placeholder="Search documents by name, type, or status..."
      />

      <!-- Documents Table -->
      <div class="bg-white rounded-lg shadow">
        <div class="p-6 border-b">
          <h3 class="text-lg font-semibold">
            Documents ({{ filteredDocuments.length }})
          </h3>
          <p class="text-sm text-gray-500">
            Complete list of all uploaded documents
          </p>
        </div>
        <div class="p-6">
          <div class="overflow-x-auto">
            <DocumentsTable
              :documents="filteredDocuments"
              @delete="handleDeleteDocument"
              @edit="handleEditDocument"
              @download="handleDownloadDocument"
              @preview="handlePreviewDocument"
            />
          </div>
        </div>
      </div>

      <!-- Document Dialog -->
      <DialogModal
        :show="showDialog"
        :title="isEditing ? 'Edit Document' : 'Upload New Document'"
        :description="
          isEditing
            ? 'Update document information.'
            : 'Upload a new document and provide details.'
        "
        :submit-text="isEditing ? 'Update' : 'Upload'"
        @cancel="resetForm"
        @submit="handleAddDocument"
      >
        <template #form>
          <DocumentForm
            :form="form"
            :types="types"
            :statuses="statuses"
            :clients="clients"
            :accounts="accounts"
            :payments="payments"
            :claims="claims"
          />
        </template>
      </DialogModal>

      <!-- Preview Modal -->
      <!-- <PreviewModal
          v-if="previewDocument"
          :document="previewDocument"
          @close="previewDocument = null"
        /> -->
    </div>
  </AuthenticatedLayout>
</template>

<script setup>
import { ref, computed, onMounted } from "vue";
import DocumentsTable from "@/Pages/Documents/Partials/ResponsiveTable.vue";
import DocumentForm from "@/Pages/Documents/Partials/DocumentForm.vue";
import SearchBox from "@/Components/Ui/SearchBox.vue";
import AddButton from "@/Components/Ui/AddButton.vue";
import DialogModal from "@/Components/Ui/DialogModal.vue";
import Select from "@/Components/Ui/Select.vue";
//import PreviewModal from "@/Components/Ui/PreviewModal.vue";
import useCrud from "@/Composables/useCrud";
import StatsCard from "@/Components/Ui/StatsCard.vue";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import InputLabel from "@/Components/Ui/InputLabel.vue";

const props = defineProps({
  initialDocuments: {
    type: Array,
    default: () => [],
  },
  clients: {
    type: Array,
    required: true,
  },
  accounts: {
    type: Array,
    required: true,
  },
  payments: {
    type: Array,
    required: true,
  },
  claims: {
    type: Array,
    required: true,
  },
  pendingDocumentsCount: {
    type: Number,
    default: 0,
  },
  approvedDocumentsCount: {
    type: Number,
    default: 0,
  },
  totalStorageUsed: {
    type: Number,
    default: 0,
  },
  types: Object,
  statuses: Object,
});

const searchTerm = ref("");
const selectedType = ref("");
const selectedStatus = ref("");
const previewDocument = ref(null);
const documents = ref([...props.initialDocuments]);

const {
  form,
  isEditing,
  showDialog,
  handleEdit: handleEditDocument,
  handleSubmit: handleAddDocument,
  handleDelete: handleDeleteDocument,
  resetForm,
  setDefaults,
} = useCrud("documents", "document", documents, {
  type: "other",
  status: "draft",
  documentable_id: null,
  documentable_type: null,
  file: null,
});

const filteredDocuments = computed(() => {
  const term = searchTerm.value.toLowerCase();
  const typeFilter = selectedType.value;
  const statusFilter = selectedStatus.value;

  return documents.value.filter((doc) => {
    // Search term matching
    const matchesSearch =
      !term ||
      doc.name.toLowerCase().includes(term) ||
      doc.type.toLowerCase().includes(term) ||
      doc.status.toLowerCase().includes(term);

    // Type filter matching
    const matchesType = !typeFilter || doc.type === typeFilter;

    // Status filter matching
    const matchesStatus = !statusFilter || doc.status === statusFilter;

    return matchesSearch && matchesType && matchesStatus;
  });
});

const handleDownloadDocument = (document) => {
  // Implementation for downloading document
  console.log("Downloading document:", document);
};

const handlePreviewDocument = (document) => {
  previewDocument.value = document;
};

const formatStorage = (bytes) => {
  if (bytes === 0) return "0 Bytes";
  const k = 1024;
  const sizes = ["Bytes", "KB", "MB", "GB"];
  const i = Math.floor(Math.log(bytes) / Math.log(k));
  return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + " " + sizes[i];
};

onMounted(() => {
  setDefaults({
    type: "other",
    status: "draft",
    documentable_id: null,
    documentable_type: null,
    file: null,
  });
});
</script>
