<template>
  <div class="p-6 space-y-4">
    <div>
      <InputLabel for="client_id" value="Client *" />
      <SearchableSelect
        id="client_id"
        label="Client"
        v-model="form.client_id"
        class="w-full"
        :items="clients"
        item-key="slug"
        :item-value="(cl) => `${cl.firstname} ${cl.surname} - ${cl.slug}`"
        searchable
      />
      <InputError class="mt-2" :message="form.errors.client_id" />
    </div>

    <div>
      <InputLabel for="package_id" value="Package *" />
      <SearchableSelect
        id="package_id"
        label="Package"
        v-model="form.package_id"
        class="w-full"
        :items="packages"
        item-key="slug"
        :item-value="
          (pkg) =>
            `${pkg.name} (R${pkg.contribution}pm / R${pkg.coverage} cover)`
        "
        searchable
      />
      <InputError class="mt-2" :message="form.errors.package_id" />
    </div>

    <div>
      <InputLabel for="payday" value="Payment Day *" />
      <NumberInput
        id="payday"
        type="number"
        v-model="form.payday"
        min="1"
        max="31"
        required
        placeholder="Day of month (1-31)"
      />
      <InputError class="mt-2" :message="form.errors.payday" />
    </div>

    <div>
      <InputLabel for="notes" value="Notes" />
      <TextAreaInput
        id="notes"
        v-model="form.notes"
        placeholder="Additional notes about the account"
        rows="3"
      />
      <InputError class="mt-2" :message="form.errors.notes" />
    </div>
  </div>
</template>

<script setup>
import InputError from "@/Components/Ui/InputError.vue";
import InputLabel from "@/Components/Ui/InputLabel.vue";
import NumberInput from "@/Components/Ui/NumberInput.vue";
import SearchableSelect from "@/Components/Ui/SearchableSelect.vue";
import TextAreaInput from "@/Components/Ui/TextAreaInput.vue";

const props = defineProps({
  form: {
    type: Object,
    required: true,
  },
  clients: {
    type: Array,
    required: true,
    default: () => [],
  },
  packages: {
    type: Array,
    required: true,
    default: () => [],
  },
  statuses: {
    type: Object,
    required: true,
  },
});
</script>
