<template>
  <div class="relative">
    <input
      v-if="searchable && items.length > minItemsForSearch"
      v-model="searchQuery"
      type="text"
      class="w-full mb-2 rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500"
      :placeholder="`Search ${label}...`"
      @keydown.esc="searchQuery = ''"
    />

    <select
      :id="id"
      class="w-full block mt-1 rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500"
      v-model="model"
    >
      <option value="" v-if="showDefaultOption">
        {{ defaultOptionText }} {{ label }}
      </option>
      <option
        v-for="item in filteredItems"
        :key="getKey(item)"
        :value="getKey(item)"
      >
        {{ getValue(item) }}
      </option>
    </select>
  </div>
</template>

<script setup>
import { computed, ref } from "vue";

const model = defineModel({
  type: [String, Number],
  required: false,
});

const props = defineProps({
  id: {
    type: String,
    required: true,
  },
  items: {
    type: Array,
    default: () => [],
  },
  label: {
    type: String,
    required: true,
  },
  itemKey: {
    type: [String, Function],
    default: "id",
  },
  itemValue: {
    type: [String, Function],
    default: "name",
  },
  searchable: {
    type: Boolean,
    default: false,
  },
  minItemsForSearch: {
    type: Number,
    default: 10,
  },
  showDefaultOption: {
    type: Boolean,
    default: true,
  },
  defaultOptionText: {
    type: String,
    default: "Choose",
  },
});

const searchQuery = ref("");

const getKey = (item) => {
  if (!item) return null;
  if (typeof props.itemKey === "function") return props.itemKey(item);
  return item[props.itemKey] ?? item["id"] ?? item["slug"] ?? null;
};

const getValue = (item) => {
  if (!item) return "";

  // Handle function case
  if (typeof props.itemValue === "function") {
    return props.itemValue(item);
  }

  // Handle direct property access
  if (item[props.itemValue] !== undefined) {
    return item[props.itemValue];
  }

  // Fallback to name or slug if specified property doesn't exist
  return item["name"] ?? item["slug"] ?? "";
};

const filteredItems = computed(() => {
  if (!props.searchable || searchQuery.value === "") {
    return props.items;
  }

  const query = searchQuery.value.toLowerCase();
  return props.items.filter((item) => {
    const displayValue = getValue(item).toString().toLowerCase();
    return displayValue.includes(query);
  });
});
</script>
