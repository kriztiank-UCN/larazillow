<template>
  <div>Index</div>
    <Link href="/hello">Show Page</Link>
    <div>The message is: {{ msg }}</div>
</template>

<script setup>
defineProps({
    msg: String
});
</script>

<!-- <script>
import MainLayout from "../../Layouts/MainLayout.vue";
export default {
    // Using inertia persistent layout...
    layout: MainLayout,
};
</script> -->
