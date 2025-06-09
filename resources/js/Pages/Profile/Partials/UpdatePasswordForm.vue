<template>
  <div v-if="activeTab === 'password'">
    <h2 class="text-3xl font-bold text-gray-900 mb-8">Change PIN (5-digits)</h2>

    <form @submit.prevent="updatePassword" class="max-w-2xl">
      <div class="space-y-6">
        <div>
          <InputLabel for="current_password" value="Current PIN (5-digits)" />

          <TextInput
            id="current_password"
            ref="currentPasswordInput"
            v-model="form.current_password"
            type="password"
            class="mt-1 block w-full"
            autocomplete="current-password"
          />

          <InputError :message="form.errors.current_password" class="mt-2" />
        </div>

        <div>
          <InputLabel for="password" value="New PIN (5-digits)" />

          <TextInput
            id="password"
            ref="passwordInput"
            v-model="form.password"
            type="password"
            class="mt-1 block w-full"
            autocomplete="new-password"
          />

          <InputError :message="form.errors.password" class="mt-2" />
        </div>

        <div>
          <InputLabel
            for="password_confirmation"
            value="Confirm PIN (5-digits)"
          />

          <TextInput
            id="password_confirmation"
            v-model="form.password_confirmation"
            type="password"
            class="mt-1 block w-full"
            autocomplete="new-password"
          />

          <InputError
            :message="form.errors.password_confirmation"
            class="mt-2"
          />
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
      <Transition
        enter-active-class="transition ease-in-out"
        enter-from-class="opacity-0"
        leave-active-class="transition ease-in-out"
        leave-to-class="opacity-0"
      >
        <p v-if="form.recentlySuccessful" class="text-sm text-gray-600">
          Saved.
        </p>
      </Transition>
    </form>
  </div>
</template>

<script setup>
import InputError from "@/Components/Ui/InputError.vue";
import InputLabel from "@/Components/Ui/InputLabel.vue";
import PrimaryButton from "@/Components/Ui/PrimaryButton.vue";
import TextInput from "@/Components/Ui/TextInput.vue";
import { useForm } from "@inertiajs/vue3";
import { ref } from "vue";

const passwordInput = ref(null);
const currentPasswordInput = ref(null);

defineProps({
  activeTab: {
    type: String,
    default: "profile",
  },
});

const form = useForm({
  current_password: "",
  password: "",
  password_confirmation: "",
});

const updatePassword = () => {
  form.put(route("password.update"), {
    preserveScroll: true,
    onSuccess: () => form.reset(),
    onError: () => {
      if (form.errors.password) {
        form.reset("password", "password_confirmation");
        passwordInput.value.focus();
      }
      if (form.errors.current_password) {
        form.reset("current_password");
        currentPasswordInput.value.focus();
      }
    },
  });
};
</script>
