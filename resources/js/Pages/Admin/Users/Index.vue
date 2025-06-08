<template>
  <AuthenticatedLayout>
    <Head title="User Management" />

    <div class="min-h-screen bg-gray-50">
      <div class="bg-white shadow-sm border-b">
        <div class="container mx-auto px-4 py-4">
          <div class="flex items-center justify-between">
            <h1 class="text-2xl font-bold text-gray-900">User Management</h1>
          </div>
        </div>
      </div>

      <div class="container mx-auto px-4 py-8">
        <div
          class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-6"
        >
          <div>
            <h2 class="text-xl font-semibold">System Users</h2>
            <p class="text-sm text-gray-600">
              Manage all system users and their permissions
            </p>
          </div>
          <Link
            href="/users/create"
            class="flex items-center gap-2 px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700"
          >
            <Plus class="h-4 w-4" />
            Add New User
          </Link>
        </div>

        <!-- Search and Filters -->
        <div class="bg-white rounded-lg shadow p-6 mb-6">
          <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div class="flex items-center space-x-2">
              <Search class="h-4 w-4 text-gray-400" />
              <input
                type="text"
                v-model="searchTerm"
                placeholder="Search users..."
                class="flex-1 px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
              />
            </div>
            <select
              v-model="roleFilter"
              class="px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
            >
              <option value="">All Roles</option>
              <option v-for="role in roles" :value="role.id">
                {{ role.name }}
              </option>
            </select>
            <select
              v-model="statusFilter"
              class="px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
            >
              <option value="">All Statuses</option>
              <option value="active">Active</option>
              <option value="inactive">Inactive</option>
              <option value="pending">Pending</option>
            </select>
          </div>
        </div>

        <!-- Users Table -->
        <div class="bg-white rounded-lg shadow overflow-hidden">
          <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
              <thead class="bg-gray-50">
                <tr>
                  <th
                    scope="col"
                    class="py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                  >
                    User
                  </th>
                  <th
                    scope="col"
                    class="py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                  >
                    Email
                  </th>
                  <th
                    scope="col"
                    class="py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                  >
                    Role
                  </th>
                  <th
                    scope="col"
                    class="py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                  >
                    Status
                  </th>
                  <th
                    scope="col"
                    class="py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                  >
                    Last Active
                  </th>
                  <th
                    scope="col"
                    class="py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider"
                  >
                    Actions
                  </th>
                </tr>
              </thead>
              <tbody class="bg-white divide-y divide-gray-200">
                <tr v-for="user in filteredUsers" :key="user.id">
                  <td class="py-4 whitespace-nowrap">
                    <div class="flex items-center">
                      <div
                        class="flex-shrink-0 h-10 w-10 rounded-full bg-gray-200 flex items-center justify-center"
                      >
                        <span class="text-gray-600">{{ user.initials }}</span>
                      </div>
                      <div class="ml-4">
                        <div class="text-sm font-medium text-gray-900">
                          {{ user.name }}
                        </div>
                        <div class="text-sm text-gray-500">
                          {{ user.position }}
                        </div>
                      </div>
                    </div>
                  </td>
                  <td class="py-4 whitespace-nowrap text-sm text-gray-500">
                    {{ user.email }}
                  </td>
                  <td class="py-4 whitespace-nowrap">
                    <span
                      class="px-2 py-1 text-xs rounded-full"
                      :class="{
                        'bg-purple-100 text-purple-800': user.role === 'Admin',
                        'bg-blue-100 text-blue-800': user.role === 'Manager',
                        'bg-green-100 text-green-800':
                          user.role === 'Claims Officer',
                        'bg-gray-100 text-gray-800': user.role === 'Staff',
                      }"
                    >
                      {{ user.role }}
                    </span>
                  </td>
                  <td class="py-4 whitespace-nowrap">
                    <span
                      class="px-2 py-1 text-xs rounded-full"
                      :class="{
                        'bg-green-100 text-green-800': user.status === 'active',
                        'bg-red-100 text-red-800': user.status === 'inactive',
                        'bg-yellow-100 text-yellow-800':
                          user.status === 'pending',
                      }"
                    >
                      {{ user.status }}
                    </span>
                  </td>
                  <td class="py-4 whitespace-nowrap text-sm text-gray-500">
                    {{ user.last_active }}
                  </td>
                  <td
                    class="py-4 whitespace-nowrap text-right text-sm font-medium"
                  >
                    <Link
                      :href="`/users/${user.id}/edit`"
                      class="text-blue-600 hover:text-blue-900 mr-4"
                      >Edit</Link
                    >
                    <button
                      @click="confirmDelete(user)"
                      class="text-red-600 hover:text-red-900"
                    >
                      Delete
                    </button>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
          <!-- Pagination -->
          <div
            class="bg-gray-50 py-3 flex items-center justify-between border-t border-gray-200"
          >
            <div class="flex-1 flex justify-between sm:hidden">
              <button
                class="relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50"
              >
                Previous
              </button>
              <button
                class="ml-3 relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50"
              >
                Next
              </button>
            </div>
            <div
              class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between"
            >
              <div>
                <p class="text-sm text-gray-700">
                  Showing <span class="font-medium">1</span> to
                  <span class="font-medium">10</span> of
                  <span class="font-medium">20</span> results
                </p>
              </div>
              <div>
                <nav
                  class="relative z-0 inline-flex rounded-md shadow-sm -space-x-px"
                  aria-label="Pagination"
                >
                  <button
                    class="relative inline-flex items-center px-2 py-2 rounded-l-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50"
                  >
                    <span class="sr-only">Previous</span>
                    <ChevronLeft class="h-5 w-5" />
                  </button>
                  <button
                    aria-current="page"
                    class="z-10 bg-blue-50 border-blue-500 text-blue-600 relative inline-flex items-center px-4 py-2 border text-sm font-medium"
                  >
                    1
                  </button>
                  <button
                    class="bg-white border-gray-300 text-gray-500 hover:bg-gray-50 relative inline-flex items-center px-4 py-2 border text-sm font-medium"
                  >
                    2
                  </button>
                  <button
                    class="bg-white border-gray-300 text-gray-500 hover:bg-gray-50 relative inline-flex items-center px-4 py-2 border text-sm font-medium"
                  >
                    3
                  </button>
                  <button
                    class="relative inline-flex items-center px-2 py-2 rounded-r-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50"
                  >
                    <span class="sr-only">Next</span>
                    <ChevronRight class="h-5 w-5" />
                  </button>
                </nav>
              </div>
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
            <h3 class="text-lg font-medium mb-4">Delete User</h3>
            <p class="text-sm text-gray-600">
              Are you sure you want to delete {{ userToDelete?.name }}? This
              action cannot be undone.
            </p>
            <div class="mt-6 flex justify-end space-x-3">
              <button
                @click="showDeleteModal = false"
                class="px-4 py-2 border border-gray-300 rounded-md hover:bg-gray-50"
              >
                Cancel
              </button>
              <button
                @click="deleteUser"
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
import { ref, computed } from "vue";
import { Head, Link } from "@inertiajs/vue3";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Plus, Search, ChevronLeft, ChevronRight } from "lucide-vue-next";

const searchTerm = ref("");
const roleFilter = ref("");
const statusFilter = ref("");

const roles = ref([
  { id: "admin", name: "Admin" },
  { id: "manager", name: "Manager" },
  { id: "claims", name: "Claims Officer" },
  { id: "staff", name: "Staff" },
]);

const users = ref([
  {
    id: 1,
    name: "Administrator",
    initials: "A",
    email: "admin@funeralparlour.com",
    position: "System Admin",
    role: "Admin",
    status: "active",
    last_active: "Today, 10:30 AM",
  },
  {
    id: 2,
    name: "John Smith",
    initials: "JS",
    email: "john.smith@funeralparlour.com",
    position: "Claims Manager",
    role: "Manager",
    status: "active",
    last_active: "Today, 9:15 AM",
  },
  {
    id: 3,
    name: "Maria Garcia",
    initials: "MG",
    email: "maria.garcia@funeralparlour.com",
    position: "Claims Officer",
    role: "Claims Officer",
    status: "active",
    last_active: "Yesterday",
  },
  {
    id: 4,
    name: "Robert Johnson",
    initials: "RJ",
    email: "robert.johnson@funeralparlour.com",
    position: "Customer Service",
    role: "Staff",
    status: "active",
    last_active: "Yesterday",
  },
  {
    id: 5,
    name: "Sarah Williams",
    initials: "SW",
    email: "sarah.williams@funeralparlour.com",
    position: "New Hire",
    role: "Staff",
    status: "pending",
    last_active: "Never",
  },
]);

const filteredUsers = computed(() => {
  return users.value.filter((user) => {
    const matchesSearch =
      user.name.toLowerCase().includes(searchTerm.value.toLowerCase()) ||
      user.email.toLowerCase().includes(searchTerm.value.toLowerCase());
    const matchesRole =
      !roleFilter.value ||
      user.role.toLowerCase() === roleFilter.value.toLowerCase();
    const matchesStatus =
      !statusFilter.value || user.status === statusFilter.value;

    return matchesSearch && matchesRole && matchesStatus;
  });
});

const showDeleteModal = ref(false);
const userToDelete = ref(null);

const confirmDelete = (user) => {
  userToDelete.value = user;
  showDeleteModal.value = true;
};

const deleteUser = () => {
  // In a real app, you would call an API here
  users.value = users.value.filter((u) => u.id !== userToDelete.value.id);
  showDeleteModal.value = false;
};
</script>
