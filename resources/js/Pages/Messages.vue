<template>
  <AuthenticatedLayout>
    <Head title="Messages" />

    <div class="container mx-auto px-4 py-8 space-y-6">
      <!-- Header and Stats -->
      <div
        class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4"
      >
        <div>
          <h2 class="text-2xl font-bold">Messages</h2>
          <p class="text-gray-600">
            Central hub for all system messages and notifications.
          </p>
        </div>
      </div>

      <div class="container mx-auto">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
          <!-- Conversation List -->
          <div class="bg-white rounded-lg shadow overflow-hidden">
            <div class="p-4 border-b">
              <div class="flex items-center justify-between">
                <h2 class="text-lg font-semibold">Conversations</h2>
                <button class="p-2 rounded-full hover:bg-gray-100">
                  <Plus class="h-5 w-5 text-gray-600" />
                </button>
              </div>
              <div class="mt-3 relative">
                <input
                  type="text"
                  placeholder="Search messages..."
                  class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500"
                />
                <Search class="h-4 w-4 text-gray-400 absolute left-3 top-3" />
              </div>
            </div>
            <div
              class="divide-y divide-gray-200 max-h-[calc(100vh-250px)] overflow-y-auto"
            >
              <div
                v-for="conversation in conversations"
                :key="conversation.id"
                class="p-4 hover:bg-gray-50 cursor-pointer flex items-center space-x-3"
                :class="{
                  'bg-secondary-50': activeConversation === conversation.id,
                }"
                @click="activeConversation = conversation.id"
              >
                <div class="relative">
                  <div
                    class="w-10 h-10 rounded-full bg-gray-200 flex items-center justify-center"
                  >
                    <span class="text-gray-600">{{
                      conversation.initials
                    }}</span>
                  </div>
                  <span
                    v-if="conversation.unread"
                    class="absolute -top-1 -right-1 w-4 h-4 bg-red-500 rounded-full text-white text-xs flex items-center justify-center"
                  >
                    {{ conversation.unread }}
                  </span>
                </div>
                <div class="flex-1 min-w-0">
                  <div class="flex items-center justify-between">
                    <h3 class="text-sm font-medium text-gray-900 truncate">
                      {{ conversation.name }}
                    </h3>
                    <span class="text-xs text-gray-500">{{
                      conversation.time
                    }}</span>
                  </div>
                  <p class="text-sm text-gray-500 truncate">
                    {{ conversation.lastMessage }}
                  </p>
                </div>
              </div>
            </div>
          </div>

          <!-- Message Area -->
          <div class="lg:col-span-2 bg-white rounded-lg shadow overflow-hidden">
            <div v-if="activeConversation" class="flex flex-col h-full">
              <!-- Message Header -->
              <div class="p-4 border-b flex items-center justify-between">
                <div class="flex items-center space-x-3">
                  <div
                    class="w-10 h-10 rounded-full bg-gray-200 flex items-center justify-center"
                  >
                    <span class="text-gray-600">{{
                      currentConversation.initials
                    }}</span>
                  </div>
                  <div>
                    <h3 class="font-medium">{{ currentConversation.name }}</h3>
                    <p class="text-xs text-gray-500">Active now</p>
                  </div>
                </div>
                <button class="p-2 rounded-full hover:bg-gray-100">
                  <EllipsisVertical class="h-5 w-5 text-gray-600" />
                </button>
              </div>

              <!-- Messages -->
              <div class="flex-1 p-4 overflow-y-auto space-y-4 bg-gray-50">
                <div
                  v-for="message in currentConversation.messages"
                  :key="message.id"
                  class="flex"
                  :class="{ 'justify-end': message.sender === 'admin' }"
                >
                  <div
                    class="max-w-xs lg:max-w-md px-4 py-2 rounded-lg"
                    :class="{
                      'bg-primary-600 text-white': message.sender === 'admin',
                      'bg-white border border-gray-200':
                        message.sender !== 'admin',
                    }"
                  >
                    <p>{{ message.text }}</p>
                    <p
                      class="text-xs mt-1 text-right"
                      :class="{
                        'text-primary-100': message.sender === 'admin',
                        'text-gray-500': message.sender !== 'admin',
                      }"
                    >
                      {{ message.time }}
                    </p>
                  </div>
                </div>
              </div>

              <!-- Message Input -->
              <div class="p-4 border-t">
                <div class="flex items-center space-x-2">
                  <button class="p-2 rounded-full hover:bg-gray-100">
                    <Paperclip class="h-5 w-5 text-gray-600" />
                  </button>
                  <input
                    type="text"
                    v-model="newMessage"
                    placeholder="Type a message..."
                    class="flex-1 px-4 py-2 border border-gray-300 rounded-full focus:outline-none focus:ring-2 focus:ring-primary-500"
                    @keyup.enter="sendMessage"
                  />
                  <button
                    @click="sendMessage"
                    class="p-2 rounded-full bg-primary-600 text-white hover:bg-primary-700"
                  >
                    <Send class="h-5 w-5" />
                  </button>
                </div>
              </div>
            </div>

            <!-- Empty State -->
            <div
              v-else
              class="flex flex-col items-center justify-center h-full p-8 text-center"
            >
              <MessageCircle class="h-12 w-12 text-gray-400 mb-4" />
              <h3 class="text-lg font-medium text-gray-900 mb-1">
                No conversation selected
              </h3>
              <p class="text-sm text-gray-500">
                Select a conversation from the list to view messages
              </p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </AuthenticatedLayout>
</template>

<script setup>
import { ref, computed } from "vue";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import {
  Search,
  Plus,
  EllipsisVertical,
  Paperclip,
  Send,
  MessageCircle,
} from "lucide-vue-next";

const activeConversation = ref(1);
const newMessage = ref("");

const conversations = ref([
  {
    id: 1,
    name: "John Smith",
    initials: "JS",
    lastMessage: "Thanks for the information!",
    time: "10:30 AM",
    unread: 0,
    messages: [
      {
        id: 1,
        text: "Hello, I have a question about my policy",
        time: "10:15 AM",
        sender: "client",
      },
      {
        id: 2,
        text: "Hi John, how can I help you today?",
        time: "10:18 AM",
        sender: "admin",
      },
      {
        id: 3,
        text: "I wanted to know about the coverage for my plan",
        time: "10:25 AM",
        sender: "client",
      },
      {
        id: 4,
        text: "The Premium Plan covers all standard funeral services up to $10,000",
        time: "10:28 AM",
        sender: "admin",
      },
      {
        id: 5,
        text: "Thanks for the information!",
        time: "10:30 AM",
        sender: "client",
      },
    ],
  },
  {
    id: 2,
    name: "Maria Garcia",
    initials: "MG",
    lastMessage: "When will my claim be processed?",
    time: "9:45 AM",
    unread: 2,
    messages: [],
  },
  {
    id: 3,
    name: "Robert Johnson",
    initials: "RJ",
    lastMessage: "I need to update my payment method",
    time: "Yesterday",
    unread: 0,
    messages: [],
  },
  {
    id: 4,
    name: "Sarah Williams",
    initials: "SW",
    lastMessage: "Can I upgrade my plan?",
    time: "Yesterday",
    unread: 0,
    messages: [],
  },
  {
    id: 5,
    name: "David Brown",
    initials: "DB",
    lastMessage: "Thank you for your help!",
    time: "Monday",
    unread: 0,
    messages: [],
  },
]);

const currentConversation = computed(() => {
  return (
    conversations.value.find((c) => c.id === activeConversation.value) || {}
  );
});

const sendMessage = () => {
  if (!newMessage.value.trim()) return;

  const newMsg = {
    id: currentConversation.value.messages.length + 1,
    text: newMessage.value,
    time: new Date().toLocaleTimeString([], {
      hour: "2-digit",
      minute: "2-digit",
    }),
    sender: "admin",
  };

  currentConversation.value.messages.push(newMsg);
  newMessage.value = "";
};
</script>
