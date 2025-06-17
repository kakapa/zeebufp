<template>
  <div class="p-6 space-y-4">
    <div>
      <InputLabel for="name" value="Package Name" />
      <TextInput
        id="name"
        type="text"
        v-model="form.name"
        required
        autofocus
        autocomplete="name"
        placeholder="Enter package name"
      />
      <InputError class="mt-2" :message="form.errors.name" />
    </div>
    <div>
      <InputLabel for="description" value="Description" />
      <TextAreaInput
        id="description"
        v-model="form.description"
        required
        autocomplete="description"
        placeholder="Enter package description"
        rows="3"
      />
      <InputError class="mt-2" :message="form.errors.description" />
    </div>
    <div>
      <InputLabel for="contribution" value="Monthly Contribution (R)" />
      <NumberInput
        id="contribution"
        v-model="form.contribution"
        required
        autofocus
        autocomplete="contribution"
        placeholder="Enter monthly amount"
      />
      <InputError class="mt-2" :message="form.errors.contribution" />
    </div>
    <div>
      <InputLabel for="coverage" value="Coverage Amount (R)" />
      <NumberInput
        id="coverage"
        v-model="form.coverage"
        required
        autofocus
        autocomplete="coverage"
        placeholder="Enter coverage amount"
      />
      <InputError class="mt-2" :message="form.errors.coverage" />
    </div>
    <div>
      <InputLabel for="status" value="Status" />
      <Select
        id="status"
        label="Status"
        v-model="form.status"
        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary-500"
        :items="statuses"
        placeholder="Choose Status"
      />
    </div>
    <div>
      <InputLabel for="features" value="Features (separate by comma)" />
      <TextAreaInput
        id="features"
        v-model="form.features"
        required
        autocomplete="features"
        placeholder="eg. Feature 1, Feature 2, Feature 3"
        rows="4"
      />
      <InputError class="mt-2" :message="form.errors.features" />
    </div>
    <div>
      <Switch v-model="form.main" class="mt-2" :label="'Is it main package?'" />
    </div>
  </div>
</template>

<script setup>
import InputError from "@/Components/Ui/InputError.vue";
import InputLabel from "@/Components/Ui/InputLabel.vue";
import Select from "@/Components/Ui/Select.vue";
import Switch from "@/Components/Ui/Switch.vue";
import TextAreaInput from "@/Components/Ui/TextAreaInput.vue";
import TextInput from "@/Components/Ui/TextInput.vue";
import NumberInput from "@/Components/Ui/NumberInput.vue";

defineProps({
  form: {
    type: Object,
    required: true,
  },
  statuses: {
    type: Object,
    required: true,
  },
});
</script>
