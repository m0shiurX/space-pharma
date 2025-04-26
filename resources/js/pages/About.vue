<script setup>
import AuthLayout from '@/layouts/AuthLayout.vue';
import { Head } from '@inertiajs/vue3';

</script>

<template>

    <Head title="Dashboard" />

    <AuthLayout>
        <template #header>
            <h2 class="font-bold text-gray-800 text-xl leading-tight">About</h2>
        </template>
        <Swal />
        <div class="bg-white/30 mt-8 py-4 rounded-lg">
            <div class="p-8 h-96">Will setup About content here.</div>
        </div>
    </AuthLayout>
</template>
