<template>
  <div class="p-6 space-y-4">
    <!-- Document Type -->
    <div>
      <InputLabel for="type" value="Document Type *" />
      <Select
        id="type"
        label="Document Type"
        v-model="form.type"
        :items="types"
        required
      />
      <InputError class="mt-2" :message="form.errors.type" />
    </div>

    <!-- File Upload -->
    <div>
      <InputLabel value="Document File *" />
      <FileDropzone
        class="mt-1"
        :allowed-file-types="['image/*', 'application/pdf']"
        :max-file-size="25 * 1024 * 1024"
        @file-selected="handleFileSelected"
        @file-removed="handleFileRemoved"
      />
      <InputError class="mt-2" :message="form.errors.file" />
    </div>

    <!-- Associated Entity -->
    <div>
      <InputLabel value="Link To" />
      <div class="grid grid-cols-1 md:grid-cols-1 gap-4">
        <div>
          <InputLabel
            for="documentable_type"
            value="Entity Type"
            class="text-sm"
          />
          <Select
            id="documentable_type"
            label="Type"
            v-model="form.documentable_type"
            :items="entityTypes"
          />
        </div>
        <div>
          <InputLabel for="documentable_id" value="Entity" class="text-sm" />
          <SearchableSelect
            id="documentable_id"
            label="Entity"
            v-model="form.documentable_id"
            :items="getEntityOptions(form.documentable_type)"
            :disabled="!form.documentable_type"
            item-key="id"
            :item-value="getEntityLabel"
            placeholder="Select entity"
          />
        </div>
      </div>
    </div>

    <!-- Notes -->
    <div>
      <InputLabel for="notes" value="Notes" />
      <TextAreaInput
        id="notes"
        v-model="form.notes"
        placeholder="Additional notes about this document"
        rows="3"
      />
      <InputError class="mt-2" :message="form.errors.notes" />
    </div>
  </div>
</template>

<script setup>
import InputError from "@/Components/Ui/InputError.vue";
import InputLabel from "@/Components/Ui/InputLabel.vue";
import SearchableSelect from "@/Components/Ui/SearchableSelect.vue";
import Select from "@/Components/Ui/Select.vue";
import TextAreaInput from "@/Components/Ui/TextAreaInput.vue";
import FileDropzone from "@/Components/Ui/FileDropzone.vue";

const props = defineProps({
  form: {
    type: Object,
    required: true,
  },
  types: {
    type: Object,
    required: true,
  },
  statuses: {
    type: Object,
    required: true,
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
});

const emit = defineEmits(["file-selected"]);

const entityTypes = {
  "": "None",
  Client: "Client",
  Account: "Account",
  Payment: "Payment",
  Claim: "Claim",
};

const handleFileSelected = (file) => {
  if (file) {
    props.form.file = file;
  }
};

const handleFileRemoved = () => {
  props.form.file = null;
};

const getEntityOptions = (type) => {
  switch (type) {
    case "Client":
      return props.clients;
    case "Account":
      return props.accounts;
    case "Payment":
      return props.payments;
    case "Claim":
      return props.claims;
    default:
      return [];
  }
};

const getEntityLabel = (entity) => {
  if (!entity) return "";

  if (entity.firstname && entity.surname) {
    return `${entity.firstname} ${entity.surname}`;
  }
  if (entity.slug) {
    return entity.slug;
  }
  if (entity.name) {
    return entity.name;
  }
  return entity.id;
};
</script>
