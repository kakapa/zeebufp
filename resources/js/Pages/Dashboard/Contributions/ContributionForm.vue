<template>
  <div class="p-6 space-y-4">
    <div>
      <InputLabel for="account_id" value="Account *" />
      <SearchableSelect
        id="account_id"
        label="Account"
        v-model="form.account_id"
        :items="accounts"
        item-key="id"
        :item-value="(acc) => `${acc.slug}`"
        searchable
        required
      />
      <InputError class="mt-2" :message="form.errors.account_id" />
    </div>

    <div>
      <InputLabel for="amount" value="Amount (ZAR) *" />
      <NumberInput
        id="amount"
        type="number"
        v-model="form.amount"
        min="0"
        step="0.01"
        required
        placeholder="Enter amount"
      />
      <InputError class="mt-2" :message="form.errors.amount" />
    </div>

    <div>
      <InputLabel for="method" value="Payment Method *" />
      <Select
        id="method"
        label="Payment Method"
        v-model="form.method"
        :items="methodOptions"
        required
      />
      <InputError class="mt-2" :message="form.errors.method" />
    </div>

    <div>
      <InputLabel for="reference" value="Reference" />
      <TextInput
        id="reference"
        type="text"
        v-model="form.reference"
        placeholder="Payment reference/description"
      />
      <InputError class="mt-2" :message="form.errors.reference" />
    </div>

    <div>
      <InputLabel for="notes" value="Notes" />
      <TextAreaInput
        id="notes"
        v-model="form.notes"
        placeholder="Additional notes about this contribution"
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
import Select from "@/Components/Ui/Select.vue";
import TextAreaInput from "@/Components/Ui/TextAreaInput.vue";
import TextInput from "@/Components/Ui/TextInput.vue";

defineProps({
  form: {
    type: Object,
    required: true,
  },
  accounts: {
    type: Array,
    required: true,
  },
  methodOptions: {
    type: Object,
    required: true,
  },
});
</script>
