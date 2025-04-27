<template>
    <Head title="Manufacturers" />

    <AppLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">Create New Manufacturer</h2>
        </template>

        <div class="mt-8 rounded-lg bg-white/30 py-8">
            <div class="rounded-lg px-4 md:px-8 xl:px-10">
                <!-- <form class="" @submit.prevent="updateManufacturer"> -->
                <div class="mx-auto max-w-lg rounded-xl bg-white p-6 shadow-lg">
                    <!-- Header -->
                    <div class="mb-6">
                        <h2 class="text-2xl font-bold text-gray-800">Manufacturer Details</h2>
                        <p class="mt-1 text-gray-600">Review and manage manufacturer information</p>
                    </div>

                    <!-- Data Display -->
                    <div class="space-y-4">
                        <!-- Name -->
                        <div class="flex items-center border-b border-gray-100 py-3">
                            <span class="w-32 text-sm font-medium text-gray-500">Name</span>
                            <span class="text-gray-800">{{ props.manufacturer.name }}</span>
                        </div>

                        <!-- Location -->
                        <div class="flex items-center border-b border-gray-100 py-3">
                            <span class="w-32 text-sm font-medium text-gray-500">Location</span>
                            <span class="text-gray-800">{{ props.manufacturer.location }}</span>
                        </div>

                        <!-- Contact Info -->
                        <div class="rounded-lg bg-gray-50 p-4">
                            <h3 class="mb-3 text-sm font-medium text-gray-700">Contact Information</h3>

                            <div class="flex items-center border-b border-gray-100 py-2">
                                <span class="w-32 text-sm text-gray-500">Contact Person</span>
                                <span class="text-gray-800">{{ props.manufacturer.contact_name }}</span>
                            </div>

                            <div class="flex items-center pt-2">
                                <span class="w-32 text-sm text-gray-500">Phone</span>
                                <span class="text-gray-800">+88 {{ props.manufacturer.contact_tel }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Actions -->
                    <div class="mt-8 flex justify-end space-x-4">
                        <!-- Delete Button -->
                        <button
                            @click="destroyManufacturer"
                            class="flex items-center rounded-lg bg-red-500 px-5 py-2.5 text-sm font-medium text-white transition-all hover:bg-red-600 focus:outline-none focus:ring-4 focus:ring-red-300"
                        >
                            <svg xmlns="http://www.w3.org/2000/svg" class="mr-2 h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"
                                />
                            </svg>
                            Delete
                        </button>

                        <!-- Edit Button -->
                        <Link
                            :href="route('manufacturers.edit', manufacturer.id)"
                            class="flex items-center rounded-md bg-orange-500 px-8 py-2 text-white"
                            as="button"
                        >
                            <svg xmlns="http://www.w3.org/2000/svg" class="mr-2 h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"
                                />
                            </svg>
                            Edit
                        </Link>
                    </div>
                </div>
                <!-- </form> -->
            </div>
        </div>
    </AppLayout>
</template>
<script setup>
import AppLayout from '@/layouts/AppLayout.vue';
import { Head, Link } from '@inertiajs/vue3';
const props = defineProps({
    manufacturer: {
        type: Object,
        required: true,
    },
});
const destroyManufacturer = () => {
    if (confirm('Are you sure you want to delete this organization?')) {
        // Inertia.delete(route('manufacturers.destroy', props.manufacturer.id));
    }
};
</script>
