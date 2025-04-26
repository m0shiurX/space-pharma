<script setup>
import AppLayout from '@/layouts/AppLayout.vue';
import { Head } from '@inertiajs/vue3';
</script>

<template>
    <Head title="Dashboard" />

    <AppLayout>
        <template #header>
            <h2 class="text-xl font-bold leading-tight text-gray-800">About</h2>
        </template>
        <Swal />
        <div class="mt-8 rounded-lg bg-white/30 py-4">
            <div class="h-96 p-8">Will setup About content here.</div>
        </div>
    </AppLayout>
</template>
