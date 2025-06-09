<template>
  <div class="p-6 space-y-4">
    <div>
      <InputLabel for="client_id" value="Client *" />
      <SearchableSelect
        id="client_id"
        label="Client"
        v-model="form.client_id"
        :items="clients"
        item-key="id"
        :item-value="(client) => `${client.firstname} ${client.surname}`"
        searchable
        required
      />
      <InputError class="mt-2" :message="form.errors.client_id" />
    </div>

    <div>
      <InputLabel for="submission_at" value="Submission Date *" />
      <TextInput
        id="submission_at"
        type="date"
        v-model="form.submission_at"
        required
      />
      <InputError class="mt-2" :message="form.errors.submission_at" />
    </div>

    <div>
      <InputLabel for="status" value="Status *" />
      <Select
        id="status"
        label="Status"
        v-model="form.status"
        :items="statuses"
        required
      />
      <InputError class="mt-2" :message="form.errors.status" />
    </div>

    <div>
      <InputLabel for="type" value="Type *" />
      <Select
        id="type"
        label="Type"
        v-model="form.type"
        :items="typeOptions"
        required
      />
      <InputError class="mt-2" :message="form.errors.type" />
    </div>

    <div>
      <InputLabel for="description" value="Description" />
      <TextAreaInput
        id="description"
        v-model="form.description"
        placeholder="Claim details and supporting information"
        rows="4"
      />
      <InputError class="mt-2" :message="form.errors.description" />
    </div>
  </div>
</template>

<script setup>
import InputError from "@/Components/Ui/InputError.vue";
import InputLabel from "@/Components/Ui/InputLabel.vue";
import SearchableSelect from "@/Components/Ui/SearchableSelect.vue";
import Select from "@/Components/Ui/Select.vue";
import TextAreaInput from "@/Components/Ui/TextAreaInput.vue";
import TextInput from "@/Components/Ui/TextInput.vue";

defineProps({
  form: {
    type: Object,
    required: true,
  },
  clients: {
    type: Array,
    required: true,
  },
  statuses: {
    type: Object,
    required: true,
  },
  typeOptions: {
    type: Object,
    required: true,
  },
});
</script>
