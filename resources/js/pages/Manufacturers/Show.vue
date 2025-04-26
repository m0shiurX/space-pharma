<template>
    <Head title="Manufacturers" />

    <AppLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">Create New Manufacturer</h2>
        </template>

        <div class="mt-8 rounded-lg bg-white/30 py-8">
            <div class="rounded-lg px-4 md:px-8 xl:px-10">
                <form class="" @submit.prevent="updateManufacturer">
                    <div class="w-2xl mx-auto max-w-lg">
                        <h2 class="text-2xl font-bold">We cant wait to meet you!</h2>
                        <p class="mt-2 text-lg">Please fill in the details below so that we can get in contact with you.</p>
                        <div>
                            <pre>
                        {{ manufacturer }}
                    </pre
                            >
                        </div>
                        <div class="mt-6">
                            <div class="flex items-center justify-end space-x-5">
                                <button @click="destroyManufacturer" class="rounded-md bg-orange-500 px-8 py-2 text-white">Delete</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </AppLayout>
</template>
<script setup>
import AppLayout from '@/layouts/AppLayout.vue';
import { Head } from '@inertiajs/vue3';

const destroyManufacturer = () => {
    if (confirm('Are you sure you want to delete this organization?')) {
        // Inertia.delete(route('manufacturers.destroy', props.manufacturer.id));
    }
};
</script>
