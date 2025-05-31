<template>
  <Head title="Login" />

  <div
    class="min-h-screen bg-gray-100 flex flex-col justify-center py-12 sm:px-6 lg:px-8"
  >
    <div class="sm:mx-auto sm:w-full sm:max-w-md">
      <Link href="/">
        <ApplicationLogo class="mx-auto h-10 w-auto" />
      </Link>
      <h2 class="mt-6 text-center text-3xl font-extrabold text-gray-900">
        Sign in to your account
      </h2>
      <p class="mt-2 text-center text-sm text-gray-600">
        Or
        <PrimaryLink href="/register" text="create a new account" />
      </p>
    </div>

    <div class="mt-8 sm:mx-auto sm:w-full sm:max-w-md">
      <div class="bg-white py-8 px-4 shadow sm:rounded-lg sm:px-10">
        <div v-if="status" class="mb-4 text-sm font-medium text-green-600">
          {{ status }}
        </div>

        <form class="space-y-6" @submit.prevent="submit">
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

          <div>
            <InputLabel for="password" value="PIN (5-digits)" />

            <TextInput
              id="password"
              type="password"
              class="mt-1 block w-full"
              v-model="form.password"
              required
              autocomplete="current-password"
            />

            <InputError class="mt-2" :message="form.errors.password" />
          </div>

          <div class="flex items-center justify-between">
            <div class="flex items-center">
              <Checkbox name="remember" v-model:checked="form.remember" />
              <label for="remember-me" class="ml-2 block text-sm text-gray-900">
                Remember me
              </label>
            </div>

            <div class="text-sm">
              <PrimaryLink
                v-if="canResetPassword"
                :href="route('pin.request')"
                text="Forgot your PIN?"
              />
            </div>
          </div>

          <div>
            <PrimaryButton
              class="w-full"
              :class="{ 'opacity-25': form.processing }"
              :disabled="form.processing"
            >
              Sign in
            </PrimaryButton>
          </div>
        </form>

        <div class="mt-6">
          <div class="relative">
            <div class="absolute inset-0 flex items-center">
              <div class="w-full border-t border-gray-300"></div>
            </div>
            <div class="relative flex justify-center text-sm">
              <span class="px-2 bg-white text-gray-500">
                Or continue with
              </span>
            </div>
          </div>

          <div class="mt-6 grid grid-cols-3 gap-3">
            <div>
              <a
                href="#"
                class="w-full inline-flex justify-center py-2 px-4 border border-gray-300 rounded-md shadow-sm bg-white text-sm font-medium text-gray-500 hover:bg-gray-50"
              >
                <FacebookIcon class="h-5 w-5" />
              </a>
            </div>

            <div>
              <a
                href="#"
                class="w-full inline-flex justify-center py-2 px-4 border border-gray-300 rounded-md shadow-sm bg-white text-sm font-medium text-gray-500 hover:bg-gray-50"
              >
                <TwitterIcon class="h-5 w-5" />
              </a>
            </div>

            <div>
              <a
                href="#"
                class="w-full inline-flex justify-center py-2 px-4 border border-gray-300 rounded-md shadow-sm bg-white text-sm font-medium text-gray-500 hover:bg-gray-50"
              >
                <GoogleIcon class="h-5 w-5" />
              </a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { useForm } from "@inertiajs/vue3";
import { FacebookIcon, TwitterIcon } from "lucide-vue-next";
import GoogleIcon from "@/Components/icons/GoogleIcon.vue";
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import TextInput from "@/Components/TextInput.vue";
import Checkbox from "@/Components/Checkbox.vue";
import PrimaryLink from "@/Components/PrimaryLink.vue";
import ApplicationLogo from "@/Components/ApplicationLogo.vue";

defineProps({
  canResetPassword: {
    type: Boolean,
  },
  status: {
    type: String,
  },
});

const form = useForm({
  mobile_number: "",
  password: "",
  remember: false,
});

const submit = () => {
  form.post(route("login"), {
    onFinish: () => form.reset("password"),
  });
};
</script>
