<script setup lang="ts">
const svgPath = '/138419089_5043d864-cc7e-4937-8863-d783282c6709.svg';
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
    <img 
    :src="svgPath" 
    alt="Medicine Shop Logo"
    class="h-12 w-12"
  />
</template>
