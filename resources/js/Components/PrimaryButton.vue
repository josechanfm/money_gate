<script setup>
defineProps({
    type: {
        type: String,
        default: 'submit',
    },
});
</script>

<template>
    <button type="primary" class="px-6 py-3 border-green-200 rounded-md bg-green-600 text-white shadow-md flex gap-2 items-center" shape="round" >
        <slot />

        <slot name="icon"></slot>
    </button>
</template>
