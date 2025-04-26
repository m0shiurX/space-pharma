<template>
    <div class="w-full">
        <Link
            class="group flex items-center py-3 pl-4 uppercase group-hover:border-r-4 group-hover:border-orange-600 group-hover:from-orange-50 group-hover:to-orange-100"
            :class="active && 'bg-linear-to-r border-r-4 border-orange-600 from-orange-50 to-orange-100'"
            :href="href"
        >
            <div class="flex w-1/5 items-center justify-center">
                <icon :icon="icon" class="h-4 w-4 group-hover:stroke-orange-600" :class="active ? 'stroke-orange-600' : 'stroke-slate-400'" />
            </div>
            <div class="w-4/5 truncate group-hover:text-orange-600" :class="active ? 'text-orange-600' : 'text-slate-400'">
                <slot />
            </div>
        </Link>
    </div>
</template>

<script setup>
// Components
import Icon from '@/Shared/Icon.vue';
import { Link } from '@inertiajs/vue3';

defineProps(['href', 'active', 'icon']);
</script>
