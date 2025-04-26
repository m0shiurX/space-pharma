<template>

    <Head title="Manufacturers" />

    <AppLayout>
        <template #header>
            <h2 class="font-semibold text-gray-800 text-xl leading-tight">Create New Manufacturer</h2>
        </template>

        <div class="bg-white/30 mt-8 py-8 rounded-lg">
            <div class="px-4 md:px-8 xl:px-10 rounded-lg">
                <form class="" @submit.prevent="updateManufacturer">
                    <div class="mx-auto w-2xl max-w-lg">
                        <h2 class="font-bold text-2xl">We cant wait to meet you!</h2>
                        <p class="mt-2 text-lg">Please fill in the details below so that we can get in contact with you.
                        </p>
                        <div>
                            <pre>
                        {{ props.manufacturer }}
                    </pre>
                        </div>
                        <div class="mt-6">
                            <div class="flex justify-end items-center space-x-5">
                                <button @click="destroyManufacturer"
                                    class="bg-orange-500 px-8 py-2 rounded-md text-white">Delete</button>
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
