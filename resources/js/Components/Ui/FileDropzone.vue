<template>
  <div
    class="border-2 border-dashed rounded-lg p-6 transition-all"
    :class="{
      'border-gray-300 bg-gray-50': !isDragging,
      'border-blue-500 bg-blue-50': isDragging,
      'border-red-500 bg-red-50': error,
    }"
    @dragover.prevent="handleDragOver"
    @dragleave="handleDragLeave"
    @drop.prevent="handleDrop"
  >
    <div class="text-center">
      <CloudUpload class="mx-auto h-12 w-12 text-gray-400" />
      <div class="mt-4 flex justify-center text-sm text-gray-600">
        <label
          for="file-upload"
          class="relative cursor-pointer rounded-md font-medium text-blue-600 hover:text-blue-500 focus-within:outline-none"
        >
          <span>Upload a file</span>
          <input
            id="file-upload"
            ref="fileInput"
            type="file"
            class="sr-only"
            @change="handleFileSelect"
          />
        </label>
        <p class="pl-1">or drag and drop</p>
      </div>
      <p class="mt-1 text-xs text-gray-500">
        {{ allowedFileTypesText }}
      </p>
      <div v-if="file" class="mt-4">
        <div class="flex items-center justify-center">
          <FileText class="h-5 w-5 text-gray-400" />
          <span
            class="ml-2 text-sm font-medium text-gray-700 truncate max-w-xs"
          >
            {{ file.name }}
          </span>
          <button
            type="button"
            @click="removeFile"
            class="ml-2 text-gray-400 hover:text-gray-500"
          >
            <X class="h-4 w-4" />
          </button>
        </div>
        <p class="mt-1 text-xs text-gray-500">
          {{ formatFileSize(file.size) }}
        </p>
      </div>
      <p v-if="error" class="mt-2 text-sm text-red-600">
        {{ error }}
      </p>
    </div>
  </div>
</template>

<script setup>
import { ref, computed } from "vue";
import { CloudUpload, FileText, X } from "lucide-vue-next";

const props = defineProps({
  allowedFileTypes: {
    type: Array,
    default: () => ["image/*", "application/pdf"],
  },
  maxFileSize: {
    type: Number,
    default: 10 * 1024 * 1024, // 10MB
  },
});

const emit = defineEmits(["file-selected", "file-removed"]);

const fileInput = ref(null);
const isDragging = ref(false);
const file = ref(null);
const error = ref(null);

const allowedFileTypesText = computed(() => {
  const types = props.allowedFileTypes.map((type) => {
    if (type === "image/*") return "Images";
    if (type === "application/pdf") return "PDF";
    if (type === "text/plain") return "Text";
    return type.split("/").pop().toUpperCase();
  });
  return `Supports: ${types.join(", ")} (Max ${formatFileSize(
    props.maxFileSize
  )})`;
});

const handleDragOver = () => {
  isDragging.value = true;
};

const handleDragLeave = () => {
  isDragging.value = false;
};

const handleDrop = (e) => {
  isDragging.value = false;
  if (e.dataTransfer.files && e.dataTransfer.files.length > 0) {
    handleFile(e.dataTransfer.files[0]);
  }
};

const handleFileSelect = (e) => {
  if (e.target.files && e.target.files.length > 0) {
    handleFile(e.target.files[0]);
  }
};

const handleFile = (selectedFile) => {
  // Validate file type
  if (
    props.allowedFileTypes.length > 0 &&
    !props.allowedFileTypes.some((type) => {
      if (type.endsWith("/*")) {
        return selectedFile.type.startsWith(type.split("/*")[0]);
      }
      return selectedFile.type === type;
    })
  ) {
    error.value = `File type not allowed. Allowed types: ${props.allowedFileTypes.join(
      ", "
    )}`;
    return;
  }

  // Validate file size
  if (selectedFile.size > props.maxFileSize) {
    error.value = `File too large. Maximum size is ${formatFileSize(
      props.maxFileSize
    )}`;
    return;
  }

  error.value = null;
  file.value = selectedFile;
  emit("file-selected", selectedFile);
};

const removeFile = () => {
  file.value = null;
  fileInput.value.value = "";
  emit("file-removed");
};

const formatFileSize = (bytes) => {
  if (bytes === 0) return "0 Bytes";
  const k = 1024;
  const sizes = ["Bytes", "KB", "MB", "GB"];
  const i = Math.floor(Math.log(bytes) / Math.log(k));
  return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + " " + sizes[i];
};
</script>
