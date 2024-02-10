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

<style lang="scss" scoped></style>
