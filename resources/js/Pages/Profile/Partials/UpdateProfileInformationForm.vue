<template>
  <div v-if="activeTab === 'profile'">
    <h2 class="text-3xl font-bold text-gray-900 mb-8">Personal Information</h2>

    <div class="mb-8">
      <div class="flex items-center">
        <div class="relative">
          <div
            class="h-32 w-32 rounded-full bg-gray-200 flex items-center justify-center overflow-hidden"
          >
            <img
              v-if="form.photoUrl"
              :src="form.photoUrl"
              alt="Profile picture"
              class="h-full w-full object-cover"
            />
            <UserIcon v-else class="h-16 w-16 text-gray-400" />
          </div>
          <button
            class="absolute bottom-0 right-0 bg-white rounded-full p-2 shadow-md border border-gray-200"
          >
            <CameraIcon class="h-5 w-5 text-gray-500" />
          </button>
        </div>
        <div class="ml-6">
          <h3 class="text-xl font-medium text-gray-900">Profile Picture</h3>
          <p class="text-gray-500 mt-1">JPG, GIF or PNG. Max size of 2MB.</p>
          <button
            class="mt-3 px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500"
          >
            Upload
          </button>
        </div>
      </div>
    </div>

    <form @submit.prevent="submit" class="mt-6 space-y-6">
      <div class="grid grid-cols-1 gap-y-6 gap-x-8 sm:grid-cols-2">
        <div>
          <InputLabel for="fullnames" value="Full Names" />

          <TextInput
            id="fullnames"
            type="text"
            class="mt-1 block w-full"
            v-model="form.fullnames"
            required
            autocomplete="fullnames"
          />

          <InputError class="mt-2" :message="form.errors.fullnames" />
        </div>

        <div>
          <InputLabel for="initials" value="Initials" />

          <TextInput
            id="initials"
            type="text"
            class="mt-1 block w-full"
            v-model="form.initials"
            required
            autocomplete="initials"
          />

          <InputError class="mt-2" :message="form.errors.initials" />
        </div>

        <div>
          <InputLabel for="surname" value="Surname" />

          <TextInput
            id="surname"
            type="text"
            class="mt-1 block w-full"
            v-model="form.surname"
            required
            autocomplete="surname"
          />

          <InputError class="mt-2" :message="form.errors.surname" />
        </div>

        <div>
          <InputLabel for="id_number" value="ID Number" />

          <TextInput
            id="id_number"
            type="text"
            class="mt-1 block w-full"
            v-model="form.id_number"
            required
            autocomplete="id_number"
          />

          <InputError class="mt-2" :message="form.errors.id_number" />
        </div>

        <div>
          <InputLabel for="mobile_number" value="Mobile Number" />

          <TextInput
            id="mobile_number"
            type="text"
            class="mt-1 block w-full"
            v-model="form.mobile_number"
            required
            autocomplete="mobile_number"
          />

          <InputError class="mt-2" :message="form.errors.mobile_number" />
        </div>

        <div>
          <InputLabel for="email" value="Email" />

          <TextInput
            id="email"
            type="email"
            class="mt-1 block w-full"
            v-model="form.email"
            autocomplete="username"
          />

          <InputError class="mt-2" :message="form.errors.email" />
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
          <InputLabel for="marital_status" value="Marital Status" />

          <Select
            id="marital_status"
            label="Marital Status"
            :items="maritalStatusItems"
            v-model="form.marital_status"
          />

          <InputError class="mt-2" :message="form.errors.marital_status" />
        </div>

        <div>
          <InputLabel for="home_address" value="Home Address" />

          <TextInput
            id="home_address"
            type="text"
            class="mt-1 block w-full"
            v-model="form.home_address"
            required
            autocomplete="home_address"
          />

          <InputError class="mt-2" :message="form.errors.home_address" />
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

        <div>
          <InputLabel
            for="source"
            value="Source (How did you know about VILTURA?)"
          />

          <Select
            id="source"
            label="Source"
            :items="sourceItems"
            v-model="form.source"
          />

          <InputError class="mt-2" :message="form.errors.source" />
        </div>

        <div>
          <InputLabel for="about" value="About Me" />

          <TextAreaInput
            id="about"
            class="mt-1 block w-full"
            v-model="form.about"
            autocomplete="about"
          />

          <InputError class="mt-2" :message="form.errors.about" />
        </div>

        <div class="mt-5">
          <Switch v-model="form.disability" label="Do you have a disability?" />

          <InputError class="mt-2" :message="form.errors.disability" />
        </div>
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

      <div class="mt-8 flex justify-end">
        <button
          type="button"
          class="mr-3 px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500"
        >
          Cancel
        </button>
        <PrimaryButton :disabled="form.processing">Save Changes</PrimaryButton>
      </div>
    </form>
  </div>
</template>

<script setup>
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import Select from "@/Components/Select.vue";
import TextAreaInput from "@/Components/TextAreaInput.vue";
import TextInput from "@/Components/TextInput.vue";
import Switch from "@/Components/Switch.vue";
import { useForm, usePage } from "@inertiajs/vue3";
import { useToast } from "vue-toast-notification";
import { UserIcon, CameraIcon } from "lucide-vue-next";

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
  maritalStatusItems: {
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
  disability: {
    type: Boolean,
  },
  activeTab: {
    type: String,
    default: "profile",
  },
});

const user = usePage().props.auth.user;
const toast = useToast();

const form = useForm({
  initials: user.initials,
  fullnames: user.fullnames,
  surname: user.surname,
  email: user.email,
  mobile_number: user.mobile_number,
  country: user.country,
  country_code: user.country_code,
  //home_phone_number: user.home_phone_number,
  id_number: user.id_number,
  home_address: user.home_address,
  postal_code: user.postal_code,
  status: user.status,
  gender: user.gender ? user.gender : "",
  occupation: user.occupation ? user.occupation : "",
  marital_status: user.marital_status ? user.marital_status : "",
  work_status: user.work_status ? user.work_status : "",
  education_level: user.education_level ? user.education_level : "",
  about: user.about,
  disability: Boolean(user.disability),
  source: user.source ? user.source : "",
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
