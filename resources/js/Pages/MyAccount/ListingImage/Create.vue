<template>
  <Box>
    <template #header>Upload New Images</template>
    <form @submit.prevent="upload">
      <input type="file" multiple @input="addFiles" />
      <button type="submit" class="btn-outline">Upload</button>
      <button type="reset" class="btn-outline" @click="reset">Reset</button>
    </form>
  </Box>
</template>

<script setup>
import Box from "@/Components/UI/Box.vue";
import { useForm } from "@inertiajs/vue3";
const props = defineProps({ listing: Object });
const form = useForm({
  images: [],
});
const upload = () => {
  form.post(
    route("my-account.listing.image.store", { listing: props.listing.id }),
    {
      onSuccess: () => form.reset("images"),
    }
  );
};
const addFiles = (event) => {
  // Add each file to the form's images array
  // const image of is a way to iterate over all the files in the event.target.files array
  for (const image of event.target.files) {
    form.images.push(image);
  }
};
const reset = () => form.reset("images");
</script>
