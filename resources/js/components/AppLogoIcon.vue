<script setup lang="ts">
const svgPath =
    'https://img.freepik.com/free-vector/stethoscope-with-red-heart-icon_1308-127523.jpg?t=st=1745736405~exp=1745740005~hmac=6e97f65b94392f134b643a8e5dcfb6d9fbbeadd42efa0203e73aeb6494e5abbe&w=740';
import type { HTMLAttributes } from 'vue';
defineOptions({
    inheritAttrs: false,
});

interface Props {
    className?: HTMLAttributes['class'];
}

defineProps<Props>();
</script>

<template>
    <!-- <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 40 42">
        <path d="M10 12h20v20a8 8 0 01-8 8 8 8 0 01-8-8V12z" fill="#3B82F6" />
        <path d="M15 12h10v4a5 5 0 01-5 5 5 5 0 01-5-5v-4z" fill="#1D4ED8" />
        <path d="M18 8h4v4h-4z" fill="#3B82F6" />
        <path d="M16 18h8v2h-8zM16 22h8v2h-8z" fill="#FFFFFF" />
    </svg> -->
    <img :src="svgPath" alt="Medicine Shop Logo" class="h-12 w-12 rounded-full" />
</template>
