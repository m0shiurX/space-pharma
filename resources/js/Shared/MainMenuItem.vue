<template>
    <div class="w-full">
        <Link
            class="group flex items-center group-hover:from-orange-50 group-hover:to-orange-100 py-3 pl-4 group-hover:border-orange-600 group-hover:border-r-4 uppercase"
            :class="active && 'border-r-4 border-orange-600 bg-linear-to-r from-orange-50 to-orange-100'"
            :href="href">
        <div class="flex justify-center items-center w-1/5">
            <icon :icon="icon" class="w-4 h-4 group-hover:stroke-orange-600"
                :class="active ? 'stroke-orange-600' : 'stroke-slate-400'" />
        </div>
        <div class="w-4/5 group-hover:text-orange-600 truncate" :class="active ? 'text-orange-600' : 'text-slate-400'">
            <slot />
        </div>
        </Link>
    </div>
</template>

<script setup>
// Components
import { Link } from '@inertiajs/vue3';
import Icon from '@/Shared/Icon';

defineProps(['href', 'active', 'icon']);
</script>
