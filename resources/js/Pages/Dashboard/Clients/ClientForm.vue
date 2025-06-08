<template>
  <div class="p-6 space-y-4">
    <div>
      <InputLabel for="title" value="Title" />
      <Select
        id="title"
        label="Title"
        v-model="form.title"
        class="w-full"
        :items="titles"
        placeholder="Select title"
      />
      <InputError class="mt-2" :message="form.errors.title" />
    </div>
    <div>
      <InputLabel for="firstname" value="First Name *" />
      <TextInput
        id="firstname"
        type="text"
        v-model="form.firstname"
        required
        autocomplete="given-name"
        placeholder="Enter first name"
      />
      <InputError class="mt-2" :message="form.errors.firstname" />
    </div>
    <div>
      <InputLabel for="middlename" value="middle name" />
      <TextInput
        id="middlename"
        type="text"
        v-model="form.middlename"
        autocomplete="additional-name"
        placeholder="Enter middle name"
      />
      <InputError class="mt-2" :message="form.errors.middlename" />
    </div>
    <div>
      <InputLabel for="surname" value="Surname *" />
      <TextInput
        id="surname"
        type="text"
        v-model="form.surname"
        required
        autocomplete="family-name"
        placeholder="Enter surname"
      />
      <InputError class="mt-2" :message="form.errors.surname" />
    </div>
    <div>
      <InputLabel for="email" value="Email" />
      <TextInput
        id="email"
        type="email"
        v-model="form.email"
        autocomplete="email"
        placeholder="Enter email address"
      />
      <InputError class="mt-2" :message="form.errors.email" />
    </div>
    <div>
      <InputLabel for="phone" value="Phone" />
      <TextInput
        id="phone"
        type="tel"
        v-model="form.phone"
        autocomplete="tel"
        placeholder="Enter phone number"
      />
      <InputError class="mt-2" :message="form.errors.phone" />
    </div>
    <div>
      <InputLabel for="id_number" value="ID Number" />
      <TextInput
        id="id_number"
        type="text"
        v-model="form.id_number"
        placeholder="Enter South African ID"
      />
      <InputError class="mt-2" :message="form.errors.id_number" />
    </div>
    <div>
      <InputLabel for="gender" value="Gender" />
      <Select
        id="gender"
        label="Gender"
        v-model="form.gender"
        class="w-full"
        :items="genders"
        placeholder="Select gender"
      />
      <InputError class="mt-2" :message="form.errors.gender" />
    </div>
    <div>
      <InputLabel for="address" value="Address" />
      <TextInput
        id="address"
        type="text"
        v-model="form.address"
        autocomplete="street-address"
        placeholder="Enter physical address"
      />
      <InputError class="mt-2" :message="form.errors.address" />
    </div>
    <div>
      <InputLabel for="status" value="Status" />
      <Select
        id="status"
        label="Status"
        v-model="form.status"
        class="w-full"
        :items="statuses"
        placeholder="Select status"
      />
      <InputError class="mt-2" :message="form.errors.status" />
    </div>
    <div>
      <InputLabel for="referral_source" value="Referral Source" />
      <Select
        id="referral_source"
        label="Referral Source"
        v-model="form.referral_source"
        class="w-full"
        :items="referralSources"
        placeholder="How did they hear about us?"
      />
      <InputError class="mt-2" :message="form.errors.referral_source" />
    </div>
    <div>
      <InputLabel for="notes" value="Notes" />
      <TextAreaInput
        id="notes"
        v-model="form.notes"
        placeholder="Additional notes about the client"
        rows="3"
      />
      <InputError class="mt-2" :message="form.errors.notes" />
    </div>
  </div>
</template>

<script setup>
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import Select from "@/Components/Select.vue";
import TextAreaInput from "@/Components/TextAreaInput.vue";
import TextInput from "@/Components/TextInput.vue";

defineProps({
  form: {
    type: Object,
    required: true,
  },
  titles: {
    type: Object,
    required: true,
  },
  genders: {
    type: Object,
    required: true,
  },
  statuses: {
    type: Object,
    required: true,
  },
  referralSources: {
    type: Object,
    required: true,
  },
});
</script>
