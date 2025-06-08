<template>
  <AuthenticatedLayout>
    <Head title="Role Management" />

    <div class="min-h-screen bg-gray-50">
      <div class="bg-white shadow-sm border-b">
        <div class="container mx-auto px-4 py-4">
          <div class="flex items-center justify-between">
            <h1 class="text-2xl font-bold text-gray-900">Role Management</h1>
          </div>
        </div>
      </div>

      <div class="container mx-auto px-4 py-8">
        <div
          class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-6"
        >
          <div>
            <h2 class="text-xl font-semibold">System Roles</h2>
            <p class="text-sm text-gray-600">
              Manage roles and their permissions
            </p>
          </div>
          <Link
            href="/roles/create"
            class="flex items-center gap-2 px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700"
          >
            <Plus class="h-4 w-4" />
            Create Role
          </Link>
        </div>

        <!-- Roles Table -->
        <div class="bg-white rounded-lg shadow overflow-hidden">
          <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
              <thead class="bg-gray-50">
                <tr>
                  <th
                    scope="col"
                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                  >
                    Role
                  </th>
                  <th
                    scope="col"
                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                  >
                    Description
                  </th>
                  <th
                    scope="col"
                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                  >
                    Users
                  </th>
                  <th
                    scope="col"
                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                  >
                    Permissions
                  </th>
                  <th
                    scope="col"
                    class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider"
                  >
                    Actions
                  </th>
                </tr>
              </thead>
              <tbody class="bg-white divide-y divide-gray-200">
                <tr v-for="role in roles" :key="role.id">
                  <td class="px-6 py-4 whitespace-nowrap">
                    <div class="flex items-center">
                      <div
                        class="flex-shrink-0 h-10 w-10 rounded-full bg-gray-200 flex items-center justify-center"
                      >
                        <Shield class="h-5 w-5 text-gray-600" />
                      </div>
                      <div class="ml-4">
                        <div class="text-sm font-medium text-gray-900">
                          {{ role.name }}
                        </div>
                      </div>
                    </div>
                  </td>
                  <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                    {{ role.description }}
                  </td>
                  <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                    {{ role.users_count }} users
                  </td>
                  <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                    <div class="flex flex-wrap gap-1">
                      <span
                        v-for="(permission, index) in role.permissions.slice(
                          0,
                          3
                        )"
                        :key="index"
                        class="px-2 py-1 text-xs bg-gray-100 rounded-full"
                      >
                        {{ permission }}
                      </span>
                      <span
                        v-if="role.permissions.length > 3"
                        class="px-2 py-1 text-xs bg-gray-100 rounded-full"
                      >
                        +{{ role.permissions.length - 3 }} more
                      </span>
                    </div>
                  </td>
                  <td
                    class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium"
                  >
                    <Link
                      :href="`/roles/${role.id}/edit`"
                      class="text-blue-600 hover:text-blue-900 mr-4"
                      >Edit</Link
                    >
                    <button
                      @click="confirmDelete(role)"
                      class="text-red-600 hover:text-red-900"
                    >
                      Delete
                    </button>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>

        <!-- Permissions Legend -->
        <div class="mt-8 bg-white rounded-lg shadow p-6">
          <h3 class="text-lg font-medium mb-4">Permissions Legend</h3>
          <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
            <div
              v-for="permission in allPermissions"
              :key="permission"
              class="flex items-center"
            >
              <div class="w-3 h-3 rounded-full bg-blue-500 mr-2"></div>
              <span class="text-sm text-gray-700">{{ permission }}</span>
            </div>
          </div>
        </div>
      </div>

      <!-- Delete Confirmation Modal -->
      <div
        v-if="showDeleteModal"
        class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center p-4 z-50"
      >
        <div class="bg-white rounded-lg shadow-xl max-w-md w-full">
          <div class="p-6">
            <h3 class="text-lg font-medium mb-4">Delete Role</h3>
            <p class="text-sm text-gray-600">
              Are you sure you want to delete the {{ roleToDelete?.name }} role?
              This action cannot be undone.
            </p>
            <div
              v-if="roleToDelete?.users_count > 0"
              class="mt-4 bg-red-50 border-l-4 border-red-500 p-4"
            >
              <div class="flex">
                <div class="flex-shrink-0">
                  <TriangleAlert class="h-5 w-5 text-red-500" />
                </div>
                <div class="ml-3">
                  <p class="text-sm text-red-700">
                    This role is assigned to
                    {{ roleToDelete?.users_count }} users. Deleting it will
                    remove all permissions from these users.
                  </p>
                </div>
              </div>
            </div>
            <div class="mt-6 flex justify-end space-x-3">
              <button
                @click="showDeleteModal = false"
                class="px-4 py-2 border border-gray-300 rounded-md hover:bg-gray-50"
              >
                Cancel
              </button>
              <button
                @click="deleteRole"
                class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700"
              >
                Delete
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </AuthenticatedLayout>
</template>

<script setup>
import { ref } from "vue";
import { Head, Link } from "@inertiajs/vue3";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Plus, Shield, TriangleAlert } from "lucide-vue-next";

const roles = ref([
  {
    id: 1,
    name: "Admin",
    description: "Full system access",
    users_count: 1,
    permissions: [
      "users.manage",
      "roles.manage",
      "packages.manage",
      "claims.approve",
      "claims.reject",
      "reports.view",
      "settings.manage",
    ],
  },
  {
    id: 2,
    name: "Manager",
    description: "Manage claims and packages",
    users_count: 3,
    permissions: [
      "packages.manage",
      "claims.approve",
      "claims.reject",
      "reports.view",
    ],
  },
  {
    id: 3,
    name: "Claims Officer",
    description: "Process claims and client requests",
    users_count: 5,
    permissions: ["claims.process", "clients.manage"],
  },
  {
    id: 4,
    name: "Staff",
    description: "Basic system access",
    users_count: 8,
    permissions: ["clients.view", "claims.view"],
  },
]);

const allPermissions = ref([
  "users.manage",
  "roles.manage",
  "packages.manage",
  "claims.process",
  "claims.approve",
  "claims.reject",
  "clients.manage",
  "clients.view",
  "reports.view",
  "settings.manage",
  "dashboard.view",
]);

const showDeleteModal = ref(false);
const roleToDelete = ref(null);

const confirmDelete = (role) => {
  roleToDelete.value = role;
  showDeleteModal.value = true;
};

const deleteRole = () => {
  // In a real app, you would call an API here
  roles.value = roles.value.filter((r) => r.id !== roleToDelete.value.id);
  showDeleteModal.value = false;
};
</script>
