<template>
  <Head title="Forgot PIN" />

  <div
    class="min-h-screen bg-gray-100 flex flex-col justify-center py-12 sm:px-6 lg:px-8"
  >
    <div class="sm:mx-auto sm:w-full sm:max-w-md">
      <Link href="/">
        <ApplicationLogo class="mx-auto h-10 w-auto" />
      </Link>
      <h2 class="mt-6 text-center text-3xl font-extrabold text-gray-900">
        Reset PIN
      </h2>
      <p class="mt-2 text-center text-sm text-gray-600"></p>
    </div>

    <div class="mt-8 sm:mx-auto sm:w-full sm:max-w-md">
      <div class="bg-white py-8 px-4 shadow sm:rounded-lg sm:px-10">
        <div class="mb-4 text-sm text-gray-600">
          Forgot your PIN? No problem. Just let us know your mobile number and
          we will sms you a new password reset that will allow you to login
          again.
        </div>

        <div v-if="status" class="mb-4 text-sm font-medium text-green-600">
          {{ status }}
        </div>

        <form @submit.prevent="submit">
          <div>
            <InputLabel for="mobile_number" value="Mobile Number" />

            <TextInput
              id="mobile_number"
              type="text"
              class="mt-1 block w-full"
              v-model="form.mobile_number"
              required
              autofocus
              autocomplete="mobile_number"
            />

            <InputError class="mt-2" :message="form.errors.mobile_number" />
          </div>

          <div class="mt-4 flex items-center justify-end">
            <PrimaryButton
              :class="{ 'opacity-25': form.processing }"
              :disabled="form.processing"
            >
              Send new PIN
            </PrimaryButton>
          </div>
        </form>
      </div>
    </div>
  </div>
</template>

<script setup>
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import TextInput from "@/Components/TextInput.vue";
import ApplicationLogo from "@/Components/ApplicationLogo.vue";
import { Head, Link, useForm } from "@inertiajs/vue3";

defineProps({
  status: {
    type: String,
  },
});

const form = useForm({
  mobile_number: "",
});

const submit = () => {
  form.post(route("pin.mobile"));
};
</script>
