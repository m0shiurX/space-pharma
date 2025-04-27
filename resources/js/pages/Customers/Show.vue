<template>
    <Head title="Manufacturers" />

    <AppLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">Create New Manufacturer</h2>
        </template>
        <div class="rounded-lg bg-white p-6 shadow-md">
            <div class="mx-auto max-w-lg">
                <!-- Header -->
                <div class="mb-6 text-center">
                    <h2 class="text-2xl font-bold text-gray-800">Customer Details</h2>
                    <p class="mt-2 text-gray-600">Review and manage customer information</p>
                </div>

                <!-- Customer Card -->
                <div class="mb-6 rounded-lg border border-gray-200 bg-gray-50 p-5">
                    <div class="space-y-4">
                        <!-- Name -->
                        <div class="flex items-start">
                            <span class="w-24 text-sm font-medium text-gray-500">Name</span>
                            <span class="flex-1 text-gray-800">{{ props.customer.name }}</span>
                        </div>

                        <!-- Address -->
                        <div class="flex items-start">
                            <span class="w-24 text-sm font-medium text-gray-500">Address</span>
                            <span class="flex-1 text-gray-800">{{ props.customer.address }}</span>
                        </div>

                        <!-- Phone -->
                        <div class="flex items-start">
                            <span class="w-24 text-sm font-medium text-gray-500">Phone</span>
                            <span class="flex-1 text-gray-800">
                                {{ props.customer.phone }}
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Actions -->
                <div class="flex justify-end space-x-4">
                    <div class="mt-6">
                        <div class="flex items-center justify-end space-x-5">
                            <button type="button" @click="destroyCustomer" class="rounded-md bg-orange-500 px-8 py-2 text-white">Delete</button>
                        </div>
                    </div>
                    <Link
                        :href="route('customers.edit', customer.id)"
                        class="rounded-lg bg-blue-500 px-6 py-2 text-white hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500"
                    >
                        Edit Details
                    </Link>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
<script setup>
import AppLayout from '@/layouts/AppLayout.vue';
import { Head } from '@inertiajs/vue3';
const props = defineProps({
    customer: {
        type: Object,
        required: true,
    },
});
const destroyCustomer = () => {
    if (confirm('Are you sure you want to delete this organization?')) {
        // Inertia.delete(route('customers.destroy', props.customer.id));
    }
};
</script>
