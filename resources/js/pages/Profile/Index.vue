<template>

    <Head title="My Profile" />

    <AuthLayout>
        <template #header>
            <h2 class="font-semibold text-gray-800 text-xl leading-tight">My Profile</h2>
        </template>

        <div class="py-12">
            <div class="mx-auto sm:px-6 lg:px-8 max-w-7xl">
                <div class="bg-white shadow-xs sm:rounded-lg overflow-hidden">
                    <div class="bg-white p-6 border-gray-200 border-b">
                        <img v-if="user.photo" class="block ml-4 rounded-full w-24 h-24 object-cover"
                            :src="user.photo" />
                        <div>{{ user.name }}</div>
                        <div>{{ user.email }}</div>

                        <Link :href="route('profile.edit')"> Edit Profile </Link>
                    </div>
                </div>
            </div>
        </div>
    </AuthLayout>
</template>

<script setup>
import { Head, Link } from '@inertiajs/vue3';
import AuthLayout from '@/Layouts/AuthLayout.vue';

defineProps({
    user: Object,
});
</script>
