<template>
    <Link href="/">Main Page</Link>&nbsp;
    <Link href="/hello">Show Page</Link>

    <slot>Default</slot>
</template>

<script setup>
import { computed } from 'vue'
import { usePage } from '@inertiajs/inertia-vue3'
// const x = ref(0)
// const y = computed(() => x.value * 2)
const page = usePage()
const flashSuccess = computed(
  () => page.props.value.flash.success,
)

</script>
