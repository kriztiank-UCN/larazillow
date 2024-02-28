<template>
  <Box>
    <template #header>Upload New Images</template>
    <form @submit.prevent="upload">
      <section class="flex items-center gap-2 my-4">
        <input
          class="border rounded-md file:px-4 file:py-2 border-gray-200 dark:border-gray-700 file:text-gray-700 file:dark:text-gray-400 file:border-0 file:bg-gray-100 file:dark:bg-gray-800 file:font-medium file:hover:bg-gray-200 file:dark:hover:bg-gray-700 file:hover:cursor-pointer file:mr-4"
          type="file"
          multiple
          @input="addFiles"
        />
        <button
          type="submit"
          class="btn-outline disabled:opacity-25 disabled:cursor-not-allowed"
          :disabled="!canUpload"
        >
          Upload
        </button>
        <button type="reset" class="btn-outline" @click="reset">Reset</button>
      </section>
    </form>
  </Box>
  <!-- Show Listing Images -->
  <Box v-if="listing.images.length" class="mt-4">
    <template #header>Current Listing Images</template>
    <section class="mt-4 grid grid-cols-3 gap-4">
      <div v-for="image in listing.images" :key="image.id" class="flex flex-col justify-between">
        <img :src="image.src" class="rounded-md" />
        <Link 
          :href="route('my-account.listing.image.destroy', { listing: props.listing.id, image: image.id })"
          method="delete"
          as="button"
          class="mt-2 btn-outline text-xs"
        >
          Delete
        </Link>
      </div>
    </section>
  </Box>
</template>

<script setup>
import { computed } from "vue";
import Box from "@/Components/UI/Box.vue";
import { useForm } from "@inertiajs/vue3";
const props = defineProps({ listing: Object });
const form = useForm({
  images: [],
});
// If there's no files in the form's images array, the upload button should be disabled
const canUpload = computed(() => form.images.length);
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
