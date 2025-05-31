<template>
  <AuthenticatedLayout>
    <Head title="Mobile Number Verification" />

    <div class="bg-gray-100 flex flex-col justify-center py-12 sm:px-6 lg:px-8">
      <div class="sm:mx-auto sm:w-full sm:max-w-md">
        <h2 class="mb-6 text-center text-3xl font-extrabold text-gray-900">
          Mobile Number Verification
        </h2>
        <div class="mb-4 text-sm text-gray-600 text-center">
          <p>Thanks for signing up!</p>
          Before getting started, could you verify your mobile number by
          vefirying the pin we have sent to your mobile number
          <b>{{ $page.props.auth.user.mobile_number }}</b>
          <p>If you didn't receive the pin, we will gladly send you another.</p>
        </div>
      </div>

      <div class="mt-8 sm:mx-auto sm:w-full sm:max-w-md">
        <div class="bg-white py-8 px-4 shadow sm:rounded-lg sm:px-10">
          <div
            class="mb-4 text-sm font-medium text-green-600"
            v-if="verificationLinkSent"
          >
            A new verification link has been sent to the mobile number you
            provided during registration.
          </div>

          <form @submit.prevent="submit">
            <div>
              <InputLabel for="code" value="Code (4-digits)" />

              <TextInput
                id="code"
                type="text"
                class="mt-1 block w-full"
                v-model="form.code"
                required
                autofocus
                autocomplete="code"
              />

              <InputError class="mt-2" :message="form.errors.code" />
            </div>

            <div class="mt-4 flex items-center gap-2">
              <PrimaryButton
                :class="{ 'opacity-25': form.processing }"
                :disabled="form.processing"
              >
                Verify Code
              </PrimaryButton>

              <Link
                :href="route('resend.code')"
                :class="{ 'opacity-25': form.processing }"
                class="px-4 py-2 border border-red-300 rounded-md shadow-sm text-sm font-medium text-red-700 bg-white hover:bg-red-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500"
                :disabled="form.processing"
              >
                Resend Code
              </Link>
            </div>
          </form>
        </div>
      </div>
    </div>
  </AuthenticatedLayout>
</template>

<script setup>
import { computed } from "vue";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import { useForm } from "@inertiajs/vue3";
import InputLabel from "@/Components/InputLabel.vue";
import TextInput from "@/Components/TextInput.vue";
import InputError from "@/Components/InputError.vue";

const props = defineProps({
  status: {
    type: String,
  },
});

const form = useForm({
  code: "",
});

const submit = () => {
  form.post(route("verify.code"));
};

const verificationLinkSent = computed(
  () => props.status === "verification-link-sent"
);
</script>
