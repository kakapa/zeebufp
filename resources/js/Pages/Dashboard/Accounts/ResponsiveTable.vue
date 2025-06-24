<template>
  <BaseTable>
    <TableHeader>
      <TableHeaderCell>Package</TableHeaderCell>
      <TableHeaderCell>Client</TableHeaderCell>
      <TableHeaderCell>Monthly</TableHeaderCell>
      <TableHeaderCell>Pay On</TableHeaderCell>
      <TableHeaderCell>Status</TableHeaderCell>
      <TableHeaderCell responsive-class="text-right">Actions</TableHeaderCell>
    </TableHeader>

    <TableBody>
      <TableRow v-for="account in filteredAccounts" :key="account.id">
        <TableCell>
          <div class="text-sm text-gray-900">
            {{ account.mainPackage.name || "N/A" }}
          </div>
          <div class="text-xs text-gray-500">ID: {{ account.slug }}</div>
        </TableCell>

        <TableCell>
          <div class="text-sm font-medium text-gray-900">
            {{ account.clientName }}
          </div>
          <div class="text-sm text-gray-500">{{ account.clientPhone }}</div>
        </TableCell>

        <TableCell>
          <div class="text-sm text-gray-900">
            {{ account.totalContributionAmountString }}
          </div>
          <div class="text-xs text-gray-500">
            Next: {{ account.nextPaymentAt ?? "N/A" }}
          </div>
        </TableCell>

        <TableCell>
          <div class="text-sm text-gray-900">
            {{ account.payday }} of every month
          </div>
          <div class="text-xs text-gray-500">
            Last: {{ account.lastPaymentAt ?? "N/A" }}
          </div>
        </TableCell>

        <TableCell>
          <span
            class="px-2 py-1 text-xs rounded-full"
            :class="statusClass(account.status)"
          >
            {{ account.statusLabel }}
          </span>
        </TableCell>

        <TableCell responsive-class="text-right">
          <div class="flex items-center justify-end space-x-3">
            <TableAction
              icon="Eye"
              color="blue"
              @click="viewAccount(account)"
            />
            <TableAction
              icon="Edit"
              color="green"
              @click="$emit('edit', account)"
            />
            <TableAction
              icon="UserPlus"
              color="blue"
              @click="$emit('createBeneficiary', account)"
            />
            <TableAction
              icon="Trash2"
              color="red"
              @click="$emit('delete', account)"
            />
          </div>
        </TableCell>
      </TableRow>
    </TableBody>
  </BaseTable>

  <DialogModal
    :show="showAccountModal"
    title="Account Details"
    description="This is the detailed view of the account."
    modal-type="view"
    @cancel="handleCloseModal"
  >
    <template #form>
      <AccountView :account="selectedAccount" :showClose="false" />
    </template>
  </DialogModal>
</template>

<script setup>
import { computed, ref } from "vue";
import {
  BaseTable,
  TableHeader,
  TableHeaderCell,
  TableBody,
  TableRow,
  TableCell,
  TableAction,
} from "@/Components/Table";
import { FileText } from "lucide-vue-next";
import DialogModal from "@/Components/Ui/DialogModal.vue";
import AccountView from "./AccountView.vue";

const props = defineProps({
  accounts: {
    type: Array,
    required: true,
  },
  filters: {
    type: Object,
    default: () => ({}),
  },
});

const emit = defineEmits(["view", "edit", "delete", "createBeneficiary"]);
const selectedAccount = ref({});
const showAccountModal = ref(false);

const filteredAccounts = computed(() => {
  const term = props.filters.search?.toLowerCase() || "";
  return props.accounts.filter((account) => {
    const searchFields = [
      account.slug,
      account.clientName,
      account.clientPhone,
      account.packageName,
    ]
      .filter(Boolean)
      .join(" ")
      .toLowerCase();

    return searchFields.includes(term);
  });
});

const statusClass = (status) => {
  return (
    {
      active: "bg-green-100 text-green-800",
      pending: "bg-yellow-100 text-yellow-800",
      inactive: "bg-red-100 text-red-800",
    }[status] || "bg-gray-100 text-gray-800"
  );
};

const viewAccount = (account) => {
  selectedAccount.value = account;
  showAccountModal.value = true;
};

const handleCloseModal = () => {
  selectedAccount.value = null;
  showAccountModal.value = false;
};
</script>
