<template>
  <Head title="Register" />

  <div
    class="min-h-screen bg-gray-100 flex flex-col justify-center py-12 sm:px-6 lg:px-8"
  >
    <div class="sm:mx-auto sm:w-full sm:max-w-md">
      <Link href="/">
        <ApplicationLogo class="mx-auto h-10 w-auto" />
      </Link>
      <h2 class="mt-6 text-center text-3xl font-extrabold text-gray-900">
        Create a new account
      </h2>
      <p class="mt-2 text-center text-sm text-gray-600">
        Or
        <PrimaryLink href="/login" text="sign in to your existing account" />
      </p>
    </div>

    <div class="mt-8 sm:mx-auto sm:w-full sm:max-w-md">
      <div class="bg-white py-8 px-4 shadow sm:rounded-lg sm:px-10">
        <form class="space-y-6" @submit.prevent="submit">
          <div>
            <InputLabel for="fullnames" value="Full Names" />

            <TextInput
              id="fullnames"
              type="text"
              class="mt-1 block w-full"
              v-model="form.fullnames"
              required
              autofocus
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
            <InputLabel for="mobile_number" value="Mobile Number" />

            <TextInput
              id="mobile_number"
              type="text"
              class="mt-1 block w-full"
              v-model="form.mobile_number"
              required
              autocomplete="username"
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
              autocomplete="new-password"
            />

            <InputError class="mt-2" :message="form.errors.password" />
          </div>

          <div>
            <InputLabel
              for="password_confirmation"
              value="Confirm PIN (5-digits)"
            />

            <TextInput
              id="password_confirmation"
              type="password"
              class="mt-1 block w-full"
              v-model="form.password_confirmation"
              required
              autocomplete="new-password"
            />

            <InputError
              class="mt-2"
              :message="form.errors.password_confirmation"
            />
          </div>

          <div class="flex items-center">
            <input
              id="terms"
              name="terms"
              type="checkbox"
              required
              v-model="form.termsAccepted"
              class="h-4 w-4 text-primary-500 focus:ring-primary-500 border-gray-300 rounded"
            />
            <label for="terms" class="ml-2 block text-sm text-gray-900">
              I agree to the
              <a
                href="#"
                class="font-medium text-primary-500 hover:text-primary-600"
                >Terms and Conditions</a
              >
              and
              <a
                href="#"
                class="font-medium text-primary-500 hover:text-primary-600"
                >Privacy Policy</a
              >
            </label>
          </div>

          <div>
            <div class="text-center">
              <Link
                :href="route('login')"
                class="rounded-md text-sm text-gray-600 underline hover:text-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2"
              >
                Already registered?
              </Link>
            </div>

            <PrimaryButton
              class="w-full mt-4"
              :class="{ 'opacity-25': form.processing }"
              :disabled="form.processing"
            >
              Register
            </PrimaryButton>
          </div>
        </form>
      </div>
    </div>
  </div>
</template>

<script setup>
import InputError from "@/Components/Ui/InputError.vue";
import InputLabel from "@/Components/Ui/InputLabel.vue";
import PrimaryButton from "@/Components/Ui/PrimaryButton.vue";
import PrimaryLink from "@/Components/Ui/PrimaryLink.vue";
import TextInput from "@/Components/Ui/TextInput.vue";
import ApplicationLogo from "@/Components/Ui/ApplicationLogo.vue";
import { useForm } from "@inertiajs/vue3";

const form = useForm({
  fullnames: "",
  initials: "",
  surname: "",
  mobile_number: "",
  password: "",
  password_confirmation: "",
  termsAccepted: false,
});

const submit = () => {
  form.post(route("register"), {
    onFinish: () => form.reset("password", "password_confirmation"),
  });
};
</script>
