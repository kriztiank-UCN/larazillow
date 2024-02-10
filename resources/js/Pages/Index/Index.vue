<template>
    <div>Index</div>
    <Link href="/hello">Show Page</Link>

    The message is: {{ msg }}
</template>

<script setup>
defineProps(['msg'])
</script>

<style lang="scss" scoped></style>
