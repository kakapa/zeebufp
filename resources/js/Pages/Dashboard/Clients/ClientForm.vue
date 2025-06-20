<template>
  <div class="p-6 space-y-4">
    <div>
      <InputLabel for="title" value="Title *" />
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
      <InputLabel for="firstname" value="Firstname *" />
      <TextInput
        id="firstname"
        type="text"
        v-model="form.firstname"
        required
        autocomplete="firstname"
        placeholder="Enter firstname"
      />
      <InputError class="mt-2" :message="form.errors.firstname" />
    </div>
    <div>
      <InputLabel for="middlename" value="Middlename" />
      <TextInput
        id="middlename"
        type="text"
        v-model="form.middlename"
        autocomplete="middlename"
        placeholder="Enter middlename (optional)"
      />
      <InputError class="mt-2" :message="form.errors.middlename" />
    </div>
    <div>
      <InputLabel for="lastname" value="Surname *" />
      <TextInput
        id="lastname"
        type="text"
        v-model="form.lastname"
        required
        autocomplete="surname"
        placeholder="Enter surname"
      />
      <InputError class="mt-2" :message="form.errors.lastname" />
    </div>
    <div>
      <InputLabel for="email" value="Email" />
      <TextInput
        id="email"
        type="email"
        v-model="form.email"
        autocomplete="email"
        placeholder="Enter email (optional)"
      />
      <InputError class="mt-2" :message="form.errors.email" />
    </div>
    <div>
      <InputLabel for="phone" value="Phone *" />
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
      <InputLabel for="id_number" value="ID Number *" />
      <TextInput
        id="id_number"
        type="text"
        v-model="form.id_number"
        placeholder="13-digits South African ID"
      />
      <InputError class="mt-2" :message="form.errors.id_number" />
    </div>
    <div>
      <InputLabel for="gender" value="Gender *" />
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
      <InputLabel for="address" value="Physical Address *" />
      <TextInput
        id="address"
        type="text"
        v-model="form.address"
        autocomplete="address"
        placeholder="Enter street address"
      />
      <InputError class="mt-2" :message="form.errors.address" />
    </div>
    <div>
      <InputLabel for="referral_source" value="Referral Source *" />
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
        placeholder="Additional notes about the client (optional)"
        rows="3"
      />
      <InputError class="mt-2" :message="form.errors.notes" />
    </div>
  </div>
</template>

<script setup>
import InputError from "@/Components/Ui/InputError.vue";
import InputLabel from "@/Components/Ui/InputLabel.vue";
import Select from "@/Components/Ui/Select.vue";
import TextAreaInput from "@/Components/Ui/TextAreaInput.vue";
import TextInput from "@/Components/Ui/TextInput.vue";

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
