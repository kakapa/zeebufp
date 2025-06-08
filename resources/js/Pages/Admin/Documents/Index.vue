<template>
  <AuthenticatedLayout>
    <Head title="Document Management" />

    <div class="min-h-screen bg-gray-50">
      <div class="bg-white shadow-sm border-b">
        <div class="container mx-auto px-4 py-4">
          <div class="flex items-center justify-between">
            <h1 class="text-2xl font-bold text-gray-900">
              Document Management
            </h1>
          </div>
        </div>
      </div>

      <div class="container mx-auto px-4 py-8">
        <div
          class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-6"
        >
          <div>
            <h2 class="text-xl font-semibold">Client Documents</h2>
            <p class="text-sm text-gray-600">
              Manage all client documents and templates
            </p>
          </div>
          <div class="flex space-x-3">
            <button
              @click="showUploadModal = true"
              class="flex items-center gap-2 px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700"
            >
              <Upload class="h-4 w-4" />
              Upload Document
            </button>
            <button
              @click="showTemplateModal = true"
              class="flex items-center gap-2 px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700"
            >
              <FilePlus class="h-4 w-4" />
              Create Template
            </button>
          </div>
        </div>

        <!-- Filters -->
        <div class="bg-white rounded-lg shadow p-6 mb-6">
          <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div class="flex items-center space-x-2">
              <Search class="h-4 w-4 text-gray-400" />
              <input
                type="text"
                v-model="searchTerm"
                placeholder="Search documents..."
                class="flex-1 px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
              />
            </div>
            <select
              v-model="documentType"
              class="px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
            >
              <option value="">All Types</option>
              <option v-for="type in documentTypes" :value="type">
                {{ type }}
              </option>
            </select>
            <select
              v-model="clientFilter"
              class="px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
            >
              <option value="">All Clients</option>
              <option v-for="client in clients" :value="client.id">
                {{ client.name }}
              </option>
            </select>
            <select
              v-model="statusFilter"
              class="px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
            >
              <option value="">All Statuses</option>
              <option value="active">Active</option>
              <option value="expired">Expired</option>
              <option value="pending">Pending Review</option>
            </select>
          </div>
        </div>

        <!-- Documents Table -->
        <div class="bg-white rounded-lg shadow overflow-hidden">
          <div class="overflow-x-auto">
            <!-- Sticky header container -->
            <div class="sticky top-0 z-10 bg-gray-50">
              <ResponsiveTable
                :documents="filteredDocuments"
                @preview="handlePreview"
                @download="handleDownload"
                @delete="handleDelete"
              />
            </div>
          </div>
          <!-- Empty State -->
          <div v-if="filteredDocuments.length === 0" class="p-12 text-center">
            <FolderOpen class="h-12 w-12 mx-auto text-gray-400" />
            <h3 class="mt-2 text-lg font-medium text-gray-900">
              No documents found
            </h3>
            <p class="mt-1 text-sm text-gray-500">
              Upload a document or adjust your filters
            </p>
          </div>
          <!-- Pagination -->
          <div
            v-else
            class="bg-gray-50 px-6 py-3 flex items-center justify-between border-t border-gray-200"
          >
            <div
              class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between"
            >
              <div>
                <p class="text-sm text-gray-700">
                  Showing <span class="font-medium">1</span> to
                  <span class="font-medium">{{
                    Math.min(filteredDocuments.length, 10)
                  }}</span>
                  of
                  <span class="font-medium">{{
                    filteredDocuments.length
                  }}</span>
                  results
                </p>
              </div>
              <div>
                <nav
                  class="relative z-0 inline-flex rounded-md shadow-sm -space-x-px"
                  aria-label="Pagination"
                >
                  <button
                    class="relative inline-flex items-center px-2 py-2 rounded-l-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50"
                  >
                    <span class="sr-only">Previous</span>
                    <ChevronLeft class="h-5 w-5" />
                  </button>
                  <button
                    aria-current="page"
                    class="z-10 bg-blue-50 border-blue-500 text-blue-600 relative inline-flex items-center px-4 py-2 border text-sm font-medium"
                  >
                    1
                  </button>
                  <button
                    class="bg-white border-gray-300 text-gray-500 hover:bg-gray-50 relative inline-flex items-center px-4 py-2 border text-sm font-medium"
                  >
                    2
                  </button>
                  <button
                    class="bg-white border-gray-300 text-gray-500 hover:bg-gray-50 relative inline-flex items-center px-4 py-2 border text-sm font-medium"
                  >
                    3
                  </button>
                  <button
                    class="relative inline-flex items-center px-2 py-2 rounded-r-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50"
                  >
                    <span class="sr-only">Next</span>
                    <ChevronRight class="h-5 w-5" />
                  </button>
                </nav>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Upload Document Modal -->
      <div
        v-if="showUploadModal"
        class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center p-4 z-50"
      >
        <div class="bg-white rounded-lg shadow-xl max-w-md w-full">
          <div class="p-6">
            <div class="flex items-center justify-between mb-4">
              <h3 class="text-lg font-medium">Upload Document</h3>
              <button
                @click="showUploadModal = false"
                class="text-gray-500 hover:text-gray-700"
              >
                <X class="h-5 w-5" />
              </button>
            </div>
            <div class="space-y-4">
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-1"
                  >Select Client</label
                >
                <select
                  v-model="newDocument.client_id"
                  class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                >
                  <option value="">Select a client</option>
                  <option v-for="client in clients" :value="client.id">
                    {{ client.name }}
                  </option>
                </select>
              </div>
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-1"
                  >Document Type</label
                >
                <select
                  v-model="newDocument.type"
                  class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                >
                  <option value="">Select type</option>
                  <option v-for="type in documentTypes" :value="type">
                    {{ type }}
                  </option>
                </select>
              </div>
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-1"
                  >Expiration Date (if applicable)</label
                >
                <input
                  type="date"
                  v-model="newDocument.expiration_date"
                  class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                />
              </div>
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-1"
                  >Upload File</label
                >
                <div
                  class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md"
                >
                  <div class="space-y-1 text-center">
                    <UploadCloud class="mx-auto h-12 w-12 text-gray-400" />
                    <div class="flex text-sm text-gray-600">
                      <label
                        for="file-upload"
                        class="relative cursor-pointer bg-white rounded-md font-medium text-blue-600 hover:text-blue-500 focus-within:outline-none"
                      >
                        <span>Upload a file</span>
                        <input
                          id="file-upload"
                          name="file-upload"
                          type="file"
                          class="sr-only"
                          @change="handleFileUpload"
                        />
                      </label>
                      <p class="pl-1">or drag and drop</p>
                    </div>
                    <p class="text-xs text-gray-500">
                      PDF, DOCX, JPG up to 10MB
                    </p>
                  </div>
                </div>
                <p v-if="newDocument.file" class="mt-2 text-sm text-gray-600">
                  Selected: {{ newDocument.file.name }} ({{
                    formatFileSize(newDocument.file.size)
                  }})
                </p>
              </div>
              <div class="flex justify-end space-x-3 pt-4">
                <button
                  @click="showUploadModal = false"
                  class="px-4 py-2 border border-gray-300 rounded-md hover:bg-gray-50"
                >
                  Cancel
                </button>
                <button
                  @click="uploadDocument"
                  class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700"
                  :disabled="!newDocument.file"
                >
                  Upload
                </button>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Create Template Modal -->
      <div
        v-if="showTemplateModal"
        class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center p-4 z-50"
      >
        <div class="bg-white rounded-lg shadow-xl max-w-md w-full">
          <div class="p-6">
            <div class="flex items-center justify-between mb-4">
              <h3 class="text-lg font-medium">Create Document Template</h3>
              <button
                @click="showTemplateModal = false"
                class="text-gray-500 hover:text-gray-700"
              >
                <X class="h-5 w-5" />
              </button>
            </div>
            <div class="space-y-4">
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-1"
                  >Template Name</label
                >
                <input
                  type="text"
                  v-model="newTemplate.name"
                  class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                  placeholder="e.g. Funeral Agreement"
                />
              </div>
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-1"
                  >Template Type</label
                >
                <select
                  v-model="newTemplate.type"
                  class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                >
                  <option value="">Select type</option>
                  <option v-for="type in documentTypes" :value="type">
                    {{ type }}
                  </option>
                </select>
              </div>
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-1"
                  >Description</label
                >
                <textarea
                  v-model="newTemplate.description"
                  rows="3"
                  class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                  placeholder="Brief description of this template"
                ></textarea>
              </div>
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-1"
                  >Template File</label
                >
                <div
                  class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md"
                >
                  <div class="space-y-1 text-center">
                    <FileText class="mx-auto h-12 w-12 text-gray-400" />
                    <div class="flex text-sm text-gray-600">
                      <label
                        for="template-upload"
                        class="relative cursor-pointer bg-white rounded-md font-medium text-blue-600 hover:text-blue-500 focus-within:outline-none"
                      >
                        <span>Upload template</span>
                        <input
                          id="template-upload"
                          name="template-upload"
                          type="file"
                          class="sr-only"
                          @change="handleTemplateUpload"
                        />
                      </label>
                      <p class="pl-1">or drag and drop</p>
                    </div>
                    <p class="text-xs text-gray-500">PDF, DOCX up to 5MB</p>
                  </div>
                </div>
                <p v-if="newTemplate.file" class="mt-2 text-sm text-gray-600">
                  Selected: {{ newTemplate.file.name }} ({{
                    formatFileSize(newTemplate.file.size)
                  }})
                </p>
              </div>
              <div class="flex justify-end space-x-3 pt-4">
                <button
                  @click="showTemplateModal = false"
                  class="px-4 py-2 border border-gray-300 rounded-md hover:bg-gray-50"
                >
                  Cancel
                </button>
                <button
                  @click="createTemplate"
                  class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700"
                  :disabled="!newTemplate.file || !newTemplate.name"
                >
                  Create Template
                </button>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Delete Confirmation Modal -->
      <div
        v-if="showDeleteModal"
        class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center p-4 z-50"
      >
        <div class="bg-white rounded-lg shadow-xl max-w-md w-full">
          <div class="p-6">
            <h3 class="text-lg font-medium mb-4">Delete Document</h3>
            <p class="text-sm text-gray-600">
              Are you sure you want to delete "{{ documentToDelete?.name }}"?
              This action cannot be undone.
            </p>
            <div class="mt-6 flex justify-end space-x-3">
              <button
                @click="showDeleteModal = false"
                class="px-4 py-2 border border-gray-300 rounded-md hover:bg-gray-50"
              >
                Cancel
              </button>
              <button
                @click="deleteDocument"
                class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700"
              >
                Delete
              </button>
            </div>
          </div>
        </div>
      </div>

      <!-- Document Preview Modal -->
      <div
        v-if="previewDocumentData"
        class="fixed inset-0 bg-black bg-opacity-75 flex items-center justify-center p-4 z-50"
      >
        <div
          class="bg-white rounded-lg shadow-xl w-full max-w-4xl max-h-[90vh] flex flex-col"
        >
          <div class="p-4 border-b flex items-center justify-between">
            <h3 class="text-lg font-medium">{{ previewDocumentData.name }}</h3>
            <div class="flex items-center space-x-4">
              <button
                @click="downloadDocument(previewDocumentData)"
                class="text-gray-600 hover:text-gray-900"
              >
                <Download class="h-5 w-5" />
              </button>
              <button
                @click="previewDocumentData = null"
                class="text-gray-600 hover:text-gray-900"
              >
                <X class="h-5 w-5" />
              </button>
            </div>
          </div>
          <div class="flex-1 overflow-auto p-4">
            <div v-if="isPdf(previewDocumentData.type)" class="h-full">
              <iframe
                :src="`/documents/${previewDocumentData.id}/preview`"
                class="w-full h-full min-h-[70vh] border"
                frameborder="0"
              ></iframe>
            </div>
            <div v-else class="flex items-center justify-center h-full">
              <div class="text-center">
                <FileText class="mx-auto h-12 w-12 text-gray-400" />
                <p class="mt-2 text-gray-600">
                  Preview not available for this file type
                </p>
                <button
                  @click="downloadDocument(previewDocumentData)"
                  class="mt-4 px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700"
                >
                  Download to View
                </button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </AuthenticatedLayout>
</template>

<script setup>
import { ref, computed } from "vue";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import {
  Upload,
  FilePlus,
  Search,
  ChevronLeft,
  ChevronRight,
  Eye,
  Download,
  Trash2,
  X,
  UploadCloud,
  FileText,
  FolderOpen,
} from "lucide-vue-next";
import ResponsiveTable from "./Partials/ResponsiveTable.vue";

// Data
const searchTerm = ref("");
const documentType = ref("");
const clientFilter = ref("");
const statusFilter = ref("");
const showUploadModal = ref(false);
const showTemplateModal = ref(false);
const showDeleteModal = ref(false);
const previewDocumentData = ref(null);
const documentToDelete = ref(null);

const documentTypes = ref([
  "Contract",
  "Identification",
  "Death Certificate",
  "Medical Report",
  "Insurance Policy",
  "Payment Receipt",
  "Authorization Form",
  "Other",
]);

const clients = ref([
  { id: 1, name: "John Smith" },
  { id: 2, name: "Maria Garcia" },
  { id: 3, name: "Robert Johnson" },
  { id: 4, name: "Sarah Williams" },
]);

const documents = ref([
  {
    id: 1,
    name: "Funeral Agreement.pdf",
    type: "Contract",
    client: { id: 1, name: "John Smith" },
    size: 2456789,
    uploaded_at: "2024-01-15T10:30:00Z",
    uploaded_by: "Admin",
    status: "active",
    expiration_date: "2025-01-15",
  },
  {
    id: 2,
    name: "Death Certificate.jpg",
    type: "Death Certificate",
    client: { id: 2, name: "Maria Garcia" },
    size: 1456789,
    uploaded_at: "2024-01-10T14:15:00Z",
    uploaded_by: "Claims Officer",
    status: "active",
    expiration_date: null,
  },
  {
    id: 3,
    name: "ID Document.pdf",
    type: "Identification",
    client: { id: 3, name: "Robert Johnson" },
    size: 3456789,
    uploaded_at: "2024-01-05T09:45:00Z",
    uploaded_by: "Manager",
    status: "pending",
    expiration_date: "2024-07-05",
  },
  {
    id: 4,
    name: "Standard Contract Template.docx",
    type: "Contract",
    client: null,
    size: 456789,
    uploaded_at: "2023-12-20T16:20:00Z",
    uploaded_by: "Admin",
    status: "active",
    expiration_date: null,
  },
]);

const newDocument = ref({
  client_id: "",
  type: "",
  expiration_date: "",
  file: null,
});

const newTemplate = ref({
  name: "",
  type: "",
  description: "",
  file: null,
});

// Computed
const filteredDocuments = computed(() => {
  return documents.value.filter((doc) => {
    const matchesSearch = doc.name
      .toLowerCase()
      .includes(searchTerm.value.toLowerCase());
    const matchesType = !documentType.value || doc.type === documentType.value;
    const matchesClient =
      !clientFilter.value ||
      (doc.client && doc.client.id.toString() === clientFilter.value);
    const matchesStatus =
      !statusFilter.value || doc.status === statusFilter.value;

    return matchesSearch && matchesType && matchesClient && matchesStatus;
  });
});

// Methods
const formatDate = (dateString) => {
  const date = new Date(dateString);
  return date.toLocaleDateString("en-US", {
    year: "numeric",
    month: "short",
    day: "numeric",
  });
};

const formatFileSize = (bytes) => {
  if (bytes === 0) return "0 Bytes";
  const k = 1024;
  const sizes = ["Bytes", "KB", "MB", "GB"];
  const i = Math.floor(Math.log(bytes) / Math.log(k));
  return parseFloat((bytes / Math.pow(k, i)).toFixed(1)) + " " + sizes[i];
};

const handleFileUpload = (event) => {
  newDocument.value.file = event.target.files[0];
};

const handleTemplateUpload = (event) => {
  newTemplate.value.file = event.target.files[0];
};

const uploadDocument = () => {
  // In a real app, you would upload to the server here
  const newDoc = {
    id: documents.value.length + 1,
    name: newDocument.value.file.name,
    type: newDocument.value.type,
    client: clients.value.find(
      (c) => c.id.toString() === newDocument.value.client_id
    ),
    size: newDocument.value.file.size,
    uploaded_at: new Date().toISOString(),
    uploaded_by: "Admin",
    status: "active",
    expiration_date: newDocument.value.expiration_date || null,
  };

  documents.value.unshift(newDoc);
  resetNewDocument();
  showUploadModal.value = false;
};

const createTemplate = () => {
  // In a real app, you would upload to the server here
  const newTemp = {
    id: documents.value.length + 1,
    name: newTemplate.value.name,
    type: newTemplate.value.type,
    client: null,
    size: newTemplate.value.file.size,
    uploaded_at: new Date().toISOString(),
    uploaded_by: "Admin",
    status: "active",
    expiration_date: null,
  };

  documents.value.unshift(newTemp);
  resetNewTemplate();
  showTemplateModal.value = false;
};

const resetNewDocument = () => {
  newDocument.value = {
    client_id: "",
    type: "",
    expiration_date: "",
    file: null,
  };
};

const resetNewTemplate = () => {
  newTemplate.value = {
    name: "",
    type: "",
    description: "",
    file: null,
  };
};

const previewDocument = (document) => {
  previewDocumentData.value = document;
};

const downloadDocument = (document) => {
  // In a real app, this would trigger a download from the server
  console.log("Downloading document:", document.name);
  // You might use something like:
  // window.open(`/documents/${document.id}/download`, '_blank');
};

const isPdf = (type) => {
  return type === "PDF" || type === "Contract"; // Just for demo purposes
};

const confirmDelete = (document) => {
  documentToDelete.value = document;
  showDeleteModal.value = true;
};

const deleteDocument = () => {
  // In a real app, you would call an API here
  documents.value = documents.value.filter(
    (d) => d.id !== documentToDelete.value.id
  );
  showDeleteModal.value = false;
  documentToDelete.value = null;
};
</script>
