<template>
  <Head title="Dashboard" />

  <AuthenticatedLayout>
    <template #header>
      <span>Dashboard</span>
    </template>

    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
      <!-- Welcome Section -->
      <div class="px-4 py-6 sm:px-0">
        <div class="bg-white overflow-hidden shadow rounded-lg">
          <div class="px-4 py-5 sm:p-6">
            <h2 class="text-lg leading-6 font-medium text-gray-900">
              Welcome back, {{ $page.props.auth.user.name }}
            </h2>
            <p class="mt-1 text-sm text-gray-500">
              Here's what's happening in your placeholder community.
            </p>
          </div>
        </div>
      </div>

      <!-- Stats Section -->
      <div class="px-4 py-6 sm:px-0">
        <div class="grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-3">
          <div
            v-for="(stat, index) in stats"
            :key="index"
            class="bg-white overflow-hidden shadow rounded-lg"
          >
            <div class="px-4 py-5 sm:p-6">
              <div class="flex items-center">
                <div class="flex-shrink-0 bg-primary-500 rounded-md p-3">
                  <component :is="stat.icon" class="h-6 w-6 text-white" />
                </div>
                <div class="ml-5 w-0 flex-1">
                  <dl>
                    <dt class="text-sm font-medium text-gray-500 truncate">
                      {{ stat.name }}
                    </dt>
                    <dd>
                      <div class="text-lg font-medium text-gray-900">
                        {{ stat.value }}
                      </div>
                    </dd>
                  </dl>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Upcoming Events -->
      <div class="px-4 py-6 sm:px-0">
        <h2 class="text-lg leading-6 font-medium text-gray-900 mb-4">
          Upcoming Events
        </h2>
        <div class="bg-white shadow overflow-hidden sm:rounded-md">
          <ul class="divide-y divide-gray-200">
            <li v-for="(event, index) in events" :key="index">
              <a href="#" class="block hover:bg-gray-50">
                <div class="px-4 py-4 sm:px-6">
                  <div class="flex items-center justify-between">
                    <p class="text-sm font-medium text-primary-600 truncate">
                      {{ event.title }}
                    </p>
                    <div class="ml-2 flex-shrink-0 flex">
                      <p
                        class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800"
                      >
                        {{ event.type }}
                      </p>
                    </div>
                  </div>
                  <div class="mt-2 sm:flex sm:justify-between">
                    <div class="sm:flex">
                      <p class="flex items-center text-sm text-gray-500">
                        <MapPinIcon
                          class="flex-shrink-0 mr-1.5 h-5 w-5 text-gray-400"
                        />
                        {{ event.location }}
                      </p>
                    </div>
                    <div
                      class="mt-2 flex items-center text-sm text-gray-500 sm:mt-0"
                    >
                      <CalendarIcon
                        class="flex-shrink-0 mr-1.5 h-5 w-5 text-gray-400"
                      />
                      <p>{{ event.date }}</p>
                    </div>
                  </div>
                </div>
              </a>
            </li>
          </ul>
        </div>
      </div>

      <!-- Recent Activity -->
      <div class="px-4 py-6 sm:px-0">
        <h2 class="text-lg leading-6 font-medium text-gray-900 mb-4">
          Recent Activity
        </h2>
        <div class="bg-white shadow overflow-hidden sm:rounded-md">
          <ul class="divide-y divide-gray-200">
            <li
              v-for="(activity, index) in activities"
              :key="index"
              class="px-4 py-4 sm:px-6"
            >
              <div class="flex items-center">
                <div class="min-w-0 flex-1 flex items-center">
                  <div class="flex-shrink-0">
                    <img
                      class="h-12 w-12 rounded-full"
                      :src="activity.userImage"
                      alt="User Avatar"
                    />
                  </div>
                  <div class="min-w-0 flex-1 px-4">
                    <div>
                      <p class="text-sm font-medium text-primary-600 truncate">
                        {{ activity.user }}
                      </p>
                      <p class="mt-1 text-sm text-gray-500">
                        {{ activity.action }}
                      </p>
                    </div>
                  </div>
                </div>
                <div>
                  <p class="text-sm text-gray-500">{{ activity.time }}</p>
                </div>
              </div>
            </li>
          </ul>
        </div>
      </div>

      <!-- Resources -->
      <div class="px-4 py-6 sm:px-0">
        <h2 class="text-lg leading-6 font-medium text-gray-900 mb-4">
          Resources
        </h2>
        <div class="grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-3">
          <div
            v-for="(resource, index) in resources"
            :key="index"
            class="bg-white overflow-hidden shadow rounded-lg"
          >
            <div class="p-5">
              <div class="flex items-center">
                <div class="flex-shrink-0">
                  <component
                    :is="resource.icon"
                    class="h-6 w-6 text-primary-500"
                  />
                </div>
                <div class="ml-3">
                  <h3 class="text-lg font-medium text-gray-900">
                    {{ resource.title }}
                  </h3>
                </div>
              </div>
              <div class="mt-4">
                <p class="text-sm text-gray-500">
                  {{ resource.description }}
                </p>
              </div>
              <div class="mt-6">
                <a
                  href="#"
                  class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-primary-500 hover:bg-primary-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500"
                >
                  View
                </a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </AuthenticatedLayout>
</template>

<script setup>
import { ref } from "vue";
import {
  MapPinIcon,
  CalendarIcon,
  UsersIcon,
  ClipboardCheckIcon,
  BookOpenIcon,
  FileTextIcon,
  ShieldIcon,
} from "lucide-vue-next";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";

const stats = ref([
  { name: "Lorem Ipsum", value: "42", icon: CalendarIcon },
  { name: "Dolor Sit Amet", value: "17", icon: ClipboardCheckIcon },
  { name: "Consectetur Adipiscing", value: "1,234", icon: UsersIcon },
]);

const events = ref([
  {
    title: "Lorem Ipsum Dolor",
    type: "Seminar",
    location: "123 Placeholder Street",
    date: "May 1, 2025",
  },
  {
    title: "Sit Amet Workshop",
    type: "Training",
    location: "456 Example Ave",
    date: "May 10, 2025",
  },
  {
    title: "Adipiscing Elit Meetup",
    type: "Networking",
    location: "789 Fictitious Rd",
    date: "May 15, 2025",
  },
]);

const activities = ref([
  {
    user: "John Doe",
    action: "Commented on lorem ipsum event.",
    time: "3 hours ago",
    userImage: "https://picsum.photos/seed/user1/100",
  },
  {
    user: "Jane Smith",
    action: "Registered for Sit Amet Workshop.",
    time: "5 hours ago",
    userImage: "https://picsum.photos/seed/user2/100",
  },
  {
    user: "Mike Johnson",
    action: "Started a new project: Dolor Initiative.",
    time: "1 day ago",
    userImage: "https://picsum.photos/seed/user3/100",
  },
  {
    user: "Lerato Moagi",
    action: "Uploaded images from recent event.",
    time: "2 days ago",
    userImage: "https://picsum.photos/seed/user4/100",
  },
]);

const resources = ref([
  {
    title: "Lorem Guide",
    description: "Lorem ipsum dolor sit amet, consectetur adipiscing elit.",
    icon: BookOpenIcon,
  },
  {
    title: "Dolor Handbook",
    description:
      "Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.",
    icon: FileTextIcon,
  },
  {
    title: "Security Toolkit",
    description: "Ut enim ad minim veniam, quis nostrud exercitation ullamco.",
    icon: ShieldIcon,
  },
]);
</script>
