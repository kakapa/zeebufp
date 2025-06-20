<template>
  <div
    v-if="activeTab === 'security'"
    class="bg-white rounded-lg shadow overflow-hidden"
  >
    <div class="p-6 border-b">
      <h2 class="text-lg font-semibold">Security Settings</h2>
      <p class="text-sm text-gray-500">
        Update your password and enable two-factor authentication.
      </p>
    </div>
    <form @submit.prevent="updatePassword">
      <div class="p-6 space-y-6">
        <div>
          <h3 class="font-medium mb-4">Change Password</h3>
          <div class="space-y-4">
            <div>
              <InputLabel
                for="current_password"
                value="Current PIN (5-digits)"
              />
              <TextInput
                id="current_password"
                ref="currentPasswordInput"
                v-model="form.current_password"
                type="password"
                autocomplete="current-password"
                placeholder="Enter your current PIN"
              />
              <InputError
                :message="form.errors.current_password"
                class="mt-2"
              />
            </div>
            <div>
              <InputLabel for="password" value="New PIN (5-digits)" />
              <TextInput
                id="password"
                ref="passwordInput"
                v-model="form.password"
                type="password"
                autocomplete="new-password"
                placeholder="e.g. 12345"
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
                autocomplete="new-password"
                placeholder="e.g. 12345"
              />
              <InputError
                :message="form.errors.password_confirmation"
                class="mt-2"
              />
            </div>
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
import TextInput from "@/Components/Ui/TextInput.vue";
import { useToast } from "vue-toast-notification";
import { useForm } from "@inertiajs/vue3";
import { ref } from "vue";

const passwordInput = ref(null);
const currentPasswordInput = ref(null);
const toast = useToast();

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
    onSuccess: () => {
      form.reset();
      toast.success("PIN successfully updated!", {
        position: "top-right",
      });
    },
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
