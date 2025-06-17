<template>
  <div class="hidden lg:block relative">
    <button
      @click="toggleQuickActions"
      class="flex items-center text-sm px-3 py-1.5 rounded-md hover:bg-gray-100"
    >
      Quick Actions
      <ChevronDown class="ml-1 h-3 w-3" />
    </button>

    <!-- Quick Actions Dropdown Menu -->
    <div
      v-show="showQuickActions"
      class="absolute top-full right-0 mt-1 w-64 bg-white rounded-md shadow-lg border border-gray-200 z-20"
    >
      <div class="p-2 space-y-1">
        <Link
          href="/admin/clients/create"
          class="flex items-center w-full px-3 py-2 text-sm rounded hover:bg-gray-100"
        >
          <User class="mr-2 h-4 w-4" />
          Add New Client
        </Link>
        <Link
          href="/admin/messages/compose"
          class="flex items-center w-full px-3 py-2 text-sm rounded hover:bg-gray-100"
        >
          <MessageCircle class="mr-2 h-4 w-4" />
          Send Message
        </Link>
        <Link
          href="/admin/reminders/create"
          class="flex items-center w-full px-3 py-2 text-sm rounded hover:bg-gray-100"
        >
          <Bell class="mr-2 h-4 w-4" />
          Create Reminder
        </Link>
      </div>
    </div>
  </div>
</template>

<script setup></script>
