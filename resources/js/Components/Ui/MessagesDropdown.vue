<template>
  <div class="relative">
    <button
      @click="toggleMessages"
      class="p-2 rounded-full hover:bg-gray-100 relative"
    >
      <MessageCircle class="h-6 w-6 sm:h-6 sm:w-6" />
      <span
        v-if="unreadMessages > 0"
        class="absolute -top-0.5 -right-0.5 h-4 w-4 sm:h-5 sm:w-5 rounded-full bg-red-500 text-white text-xs flex items-center justify-center"
      >
        {{ unreadMessages }}
      </span>
    </button>

    <!-- Messages Dropdown Menu -->
    <div
      v-show="showMessages"
      class="absolute right-0 mt-2 w-72 sm:w-80 bg-white rounded-md shadow-lg border border-gray-200 z-20"
    >
      <div class="py-1">
        <h3 class="px-4 py-2 text-sm font-medium border-b border-gray-200">
          Messages ({{ unreadMessages }} unread)
        </h3>
        <div class="max-h-96 overflow-y-auto">
          <div
            v-for="message in messages"
            :key="message.id"
            class="px-4 py-3 hover:bg-gray-50 border-b border-gray-100 last:border-b-0"
          >
            <div class="flex justify-between items-start">
              <div class="flex-1 min-w-0">
                <p class="font-medium text-sm truncate">
                  {{ message.sender }}
                </p>
                <p class="text-xs text-gray-600 mt-1 break-words">
                  {{ message.message }}
                </p>
              </div>
              <span
                v-if="message.unread"
                class="w-2 h-2 bg-primary-600 rounded-full ml-2 mt-1 flex-shrink-0"
              ></span>
            </div>
            <span class="text-xs text-gray-500 mt-1 block">{{
              message.time
            }}</span>
          </div>
        </div>
        <div class="px-4 py-2 border-t border-gray-200 text-center">
          <Link
            href="/messages"
            class="text-sm text-primary-600 hover:underline"
          >
            View all messages
          </Link>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup></script>
