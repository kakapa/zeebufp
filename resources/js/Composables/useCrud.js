import { ref } from "vue";
import { useForm } from "@inertiajs/vue3";
import { useToast } from "vue-toast-notification";

export default function useCrud(
  resourceName,
  resourceNameSingular,
  itemsRef,
  defaultFields = {}
) {
  const singleResource = resourceNameSingular || resourceName.replace(/s$/, "");
  const form = useForm({ ...defaultFields, id: null });

  const toast = useToast();
  const isEditing = ref(false);
  const showDialog = ref(false);
  const loading = ref(false);

  const setDefaults = (defaults) => {
    Object.entries(defaults).forEach(([key, value]) => {
      if (!(key in form)) {
        form[key] = value;
      }
    });
  };

  const handleEdit = (item) => {
    isEditing.value = true;
    form.clearErrors();
    form.id = item.id;

    Object.keys(item).forEach((key) => {
      if (key in form) {
        form[key] = item[key];
      }
    });

    showDialog.value = true;
  };

  const handleSubmit = () => {
    loading.value = true;
    const method = isEditing.value ? "put" : "post";
    const url = route(
      `${resourceName}.${isEditing.value ? "update" : "store"}`,
      isEditing.value ? form.id : undefined
    );

    // Only use headers if there's actually a file
    if (form.file) {
      form[method](url, {
        preserveScroll: true,
        headers: {
          "Content-Type": "multipart/form-data",
        },
        onSuccess: handleSuccess,
        //onError: handleError,
        onFinish: () => {
          loading.value = false;
        },
      });
    } else {
      form[method](url, {
        preserveScroll: true,
        onSuccess: handleSuccess,
        onError: () => {
          toast.error(
            `Failed to ${
              isEditing.value ? "update" : "create"
            } ${singleResource}.`
          );
          // console.error(error);
          console.error(
            `Error details: ${JSON.stringify(form.errors, null, 2)}`
          );
        },
        onFinish: () => {
          loading.value = false;
        },
      });
    }
  };

  const handleDelete = (id) => {
    if (!confirm(`Are you sure you want to delete this ${singleResource}?`))
      return;

    useForm({}).delete(route(`${resourceName}.destroy`, id), {
      preserveScroll: true,
      onSuccess: () => {
        itemsRef.value = itemsRef.value.filter((item) => item.id !== id);
        toast.success(`${singleResource} deleted successfully.`);
      },
      onError: () => {
        toast.error(`Failed to delete ${singleResource}.`);
      },
    });
  };

  const handleSuccess = (response) => {
    const updatedOrNewItem =
      response.props?.[singleResource] ||
      response.data?.[singleResource] ||
      response.data || // fallback
      {};

    if (isEditing.value) {
      const index = itemsRef.value.findIndex((i) => i.id === form.id);
      if (index !== -1) itemsRef.value[index] = updatedOrNewItem;
    } else {
      itemsRef.value.push(updatedOrNewItem);
    }

    toast.success(
      `${
        isEditing.value ? "Updated" : "Created"
      } ${singleResource} successfully.`
    );
    resetForm();
  };

  const resetForm = () => {
    form.reset();
    form.clearErrors();
    isEditing.value = false;
    showDialog.value = false;
  };

  return {
    form,
    isEditing,
    showDialog,
    loading,
    handleEdit,
    handleSubmit,
    handleDelete,
    resetForm,
    setDefaults,
  };
}
