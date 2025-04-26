<template>

    <Head title="Manufacturers" />

    <AuthLayout>
        <template #header>
            <h2 class="font-semibold text-gray-800 text-xl capitalize leading-tight">{{ medicine.name }}</h2>
        </template>

        <div class="bg-white/30 mt-8 py-8 rounded-lg">
            <div class="px-4 md:px-8 xl:px-10 rounded-lg">
                <div class="mx-auto w-2xl max-w-lg">
                    <h2 class="font-bold text-2xl">We cant wait to meet you!</h2>
                    <p class="mt-2 text-lg">Please fill in the details below so that we can get in contact with you.</p>
                    <div>
                        <pre>
                    {{ medicine }}
                </pre>
                    </div>
                    <div class="mt-6">
                        <div class="flex justify-end items-center space-x-5">
                            <Link :href="route('medicines.edit', medicine.id)" as="button" tabindex="0"
                                class="bg-green-500 px-8 py-2 rounded-md text-white">
                            Edit
                            </Link>
                            <button type="button" @click="destroyItem"
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
    medicine: Object,
});

const destroyItem = () => {
    if (confirm('Are you sure you want to delete?')) {
        // Inertia.delete(route('medicines.destroy', props.medicine.id));
    }
};
</script>
