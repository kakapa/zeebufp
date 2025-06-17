<template>
  <div
    v-if="activeTab === 'profile'"
    class="bg-white rounded-lg shadow overflow-hidden"
  >
    <div class="p-6 border-b">
      <h2 class="text-lg font-semibold">Profile Information</h2>
      <p class="text-sm text-gray-500">
        Update your account's profile information and email address.
      </p>
    </div>
    <form @submit.prevent="submit">
      <div class="p-6 space-y-6">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
          <div>
            <InputLabel for="firstname" value="Firstname" />
            <TextInput
              id="firstname"
              type="text"
              v-model="form.firstname"
              required
              autocomplete="firstname"
            />
            <InputError class="mt-2" :message="form.errors.firstname" />
          </div>
          <div>
            <InputLabel for="lastname" value="Surname" />
            <TextInput
              id="lastname"
              type="text"
              v-model="form.lastname"
              required
              autocomplete="lastname"
            />
            <InputError class="mt-2" :message="form.errors.lastname" />
          </div>
          <div>
            <InputLabel for="email" value="Email" />
            <TextInput
              id="email"
              type="email"
              v-model="form.email"
              autocomplete="username"
            />
            <InputError class="mt-2" :message="form.errors.email" />
          </div>
          <div>
            <InputLabel for="mobile_number" value="Mobile Number" />
            <TextInput
              id="mobile_number"
              type="text"
              v-model="form.mobile_number"
              required
              autocomplete="mobile_number"
            />
            <InputError class="mt-2" :message="form.errors.mobile_number" />
          </div>
          <div>
            <InputLabel for="id_number" value="ID Number" />
            <TextInput
              id="id_number"
              type="text"
              v-model="form.id_number"
              required
              autocomplete="id_number"
            />
            <InputError class="mt-2" :message="form.errors.id_number" />
          </div>
          <div>
            <InputLabel for="country" value="Country" />
            <Select
              id="country"
              label="Country"
              :items="countries"
              v-model="form.country_code"
            />
            <InputError class="mt-2" :message="form.errors.country_code" />
          </div>
          <div>
            <InputLabel for="gender" value="Gender" />
            <Select
              id="gender"
              label="Gender"
              :items="genderItems"
              v-model="form.gender"
            />
            <InputError class="mt-2" :message="form.errors.gender" />
          </div>
          <div>
            <InputLabel for="work_status" value="Work Status" />
            <Select
              id="work_status"
              label="Work Status"
              :items="workStatusItems"
              v-model="form.work_status"
            />
            <InputError class="mt-2" :message="form.errors.work_status" />
          </div>
          <div>
            <InputLabel for="education_level" value="Education Level" />
            <Select
              id="education_level"
              label="Education Level"
              :items="educationLevelItems"
              v-model="form.education_level"
            />
            <InputError class="mt-2" :message="form.errors.education_level" />
          </div>
          <div>
            <InputLabel for="occupation" value="Occupation" />
            <Select
              id="occupation"
              label="Occupation"
              :items="occupations"
              v-model="form.occupation"
            />
            <InputError class="mt-2" :message="form.errors.occupation" />
          </div>
        </div>

        <div>
          <InputLabel for="home_address" value="Home Address" />
          <TextInput
            id="home_address"
            type="text"
            v-model="form.home_address"
            required
            autocomplete="home_address"
          />
          <InputError class="mt-2" :message="form.errors.home_address" />
        </div>

        <div v-if="mustVerifyEmail && user.email_verified_at === null">
          <p class="mt-2 text-sm text-gray-800">
            Your email address is unverified.
            <Link
              :href="route('verification.send')"
              method="post"
              as="button"
              class="rounded-md text-sm text-gray-600 underline hover:text-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2"
            >
              Click here to re-send the verification email.
            </Link>
          </p>

          <div
            v-show="status === 'verification-link-sent'"
            class="mt-2 text-sm font-medium text-green-600"
          >
            A new verification link has been sent to your email address.
          </div>
        </div>

        <div class="flex justify-end">
          <PrimaryButton :disabled="form.processing">
            Save Changes
          </PrimaryButton>
        </div>
      </div>
    </form>
  </div>
</template>

<script setup>
import InputError from "@/Components/Ui/InputError.vue";
import InputLabel from "@/Components/Ui/InputLabel.vue";
import PrimaryButton from "@/Components/Ui/PrimaryButton.vue";
import Select from "@/Components/Ui/Select.vue";
import TextInput from "@/Components/Ui/TextInput.vue";
import { useForm, usePage } from "@inertiajs/vue3";
import { useToast } from "vue-toast-notification";

defineProps({
  mustVerifyEmail: {
    type: Boolean,
  },
  status: {
    type: String,
  },
  countries: {
    type: Object,
  },
  genderItems: {
    type: Object,
  },
  workStatusItems: {
    type: Object,
  },
  educationLevelItems: {
    type: Object,
  },
  sourceItems: {
    type: Object,
  },
  occupations: {
    type: Object,
  },
  activeTab: {
    type: String,
    default: "profile",
  },
});

const user = usePage().props.auth.user;
const toast = useToast();

const form = useForm({
  firstname: user.firstname,
  lastname: user.lastname,
  email: user.email,
  mobile_number: user.mobile_number,
  country: user.country,
  country_code: user.country_code,
  id_number: user.id_number,
  home_address: user.home_address,
  postal_code: user.postal_code,
  status: user.status,
  gender: user.gender ? user.gender : "",
  occupation: user.occupation ? user.occupation : "",
  work_status: user.work_status ? user.work_status : "",
  education_level: user.education_level ? user.education_level : "",
});

const submit = () => {
  form.patch(route("profile.update"), {
    preserveScroll: true,
    onSuccess: () => {
      toast.success("Personal info successfully updated!");
      form.reset();
    },
  });
};
</script>
