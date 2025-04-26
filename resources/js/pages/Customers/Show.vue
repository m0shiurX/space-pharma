<template>

    <Head title="Manufacturers" />

    <AuthLayout>
        <template #header>
            <h2 class="font-semibold text-gray-800 text-xl leading-tight">Create New Manufacturer</h2>
        </template>

        <div class="bg-white/30 mt-8 py-8 rounded-lg">
            <div class="px-4 md:px-8 xl:px-10 rounded-lg">
                <div class="mx-auto w-2xl max-w-lg">
                    <h2 class="font-bold text-2xl">We cant wait to meet you!</h2>
                    <p class="mt-2 text-lg">Please fill in the details below so that we can get in contact with you.</p>
                    <div>
                        <pre>
                    {{ customer }}
                </pre>
                    </div>
                    <div class="mt-6">
                        <div class="flex justify-end items-center space-x-5">
                            <button type="button" @click="destroyCustomer"
                                class="bg-orange-500 px-8 py-2 rounded-md text-white">Delete</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthLayout>
</template>
<script setup>
import { Head, Link, useForm } from '@inertiajs/vue3';
import { router } from '@inertiajs/vue3';
import AuthLayout from '@/Layouts/AuthLayout.vue';

const props = defineProps({
    customer: Object,
});

const destroyCustomer = () => {
    if (confirm('Are you sure you want to delete this organization?')) {
        // Inertia.delete(route('customers.destroy', props.customer.id));
    }
};
</script>
