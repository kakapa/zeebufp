<template>
  <div class="space-y-4">
    <div>
      <label class="block text-sm font-medium text-gray-700">Account</label>
      <input
        type="text"
        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
        :value="selectedAccount ? selectedAccount.slug : ''"
        disabled
      />
    </div>
    <div>
      <InputLabel for="firstname" value="Firstname *" />
      <TextInput
        id="firstname"
        type="text"
        v-model="beneficiaryForm.firstname"
        required
        autocomplete="firstname"
        placeholder="Enter firstname"
      />
      <InputError class="mt-2" :message="beneficiaryForm.errors.firstname" />
    </div>
    <div>
      <InputLabel for="middlename" value="Middlename" />
      <TextInput
        id="middlename"
        type="text"
        v-model="beneficiaryForm.middlename"
        autocomplete="middlename"
        placeholder="Enter middlename (optional)"
      />
      <InputError class="mt-2" :message="beneficiaryForm.errors.middlename" />
    </div>
    <div>
      <InputLabel for="lastname" value="Surname *" />
      <TextInput
        id="lastname"
        type="text"
        v-model="beneficiaryForm.lastname"
        required
        autocomplete="surname"
        placeholder="Enter surname"
      />
      <InputError class="mt-2" :message="beneficiaryForm.errors.lastname" />
    </div>
    <div>
      <InputLabel for="phone" value="Phone" />
      <TextInput
        id="phone"
        type="tel"
        v-model="beneficiaryForm.phone"
        autocomplete="tel"
        placeholder="Enter phone number"
      />
      <InputError class="mt-2" :message="beneficiaryForm.errors.phone" />
    </div>
    <div>
      <InputLabel for="id_number" value="ID Number *" />
      <TextInput
        id="id_number"
        type="text"
        v-model="beneficiaryForm.id_number"
        required
        placeholder="13-digits South African ID"
      />
      <InputError class="mt-2" :message="beneficiaryForm.errors.id_number" />
    </div>
    <div>
      <InputLabel for="gender" value="Gender *" />
      <Select
        id="gender"
        label="Gender"
        v-model="beneficiaryForm.gender"
        class="w-full"
        :items="genders"
        placeholder="Select gender"
      />
      <InputError class="mt-2" :message="beneficiaryForm.errors.gender" />
    </div>
    <div>
      <InputLabel for="gender" value="Relationship *" />
      <Select
        id="relationship"
        label="Relationship"
        v-model="beneficiaryForm.relationship"
        class="w-full"
        :items="relationships"
        placeholder="Select relationship"
      />
      <InputError class="mt-2" :message="beneficiaryForm.errors.relationship" />
    </div>
  </div>
</template>

<script setup>
import InputError from "@/Components/Ui/InputError.vue";
import InputLabel from "@/Components/Ui/InputLabel.vue";
import Select from "@/Components/Ui/Select.vue";
import TextInput from "@/Components/Ui/TextInput.vue";

defineProps({
  selectedAccount: {
    type: Object,
    required: true,
  },
  beneficiaryForm: {
    type: Object,
    required: true,
  },
  genders: {
    type: Object,
    required: true,
  },
  relationships: {
    type: Object,
    required: true,
  },
});
</script>
