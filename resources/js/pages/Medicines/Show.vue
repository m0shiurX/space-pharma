<template>
    <Head title="Manufacturers" />

    <AppLayout>
        <template #header>
            <h2 class="text-xl font-semibold capitalize leading-tight text-gray-800">{{ medicine.name }}</h2>
        </template>

        <div class="mt-8 rounded-lg bg-white/30 py-8">
            <div class="rounded-lg px-4 md:px-8 xl:px-10">
                <div class="mx-auto max-w-2xl rounded-xl bg-white p-6 shadow-md">
                    <h2 class="mb-6 text-2xl font-semibold text-gray-800">Medicine Information</h2>

                    <div class="space-y-5">
                        <!-- Row 1 -->
                        <div class="grid grid-cols-1 gap-5 md:grid-cols-2">
                            <div>
                                <label class="mb-1 block text-sm font-medium text-gray-700">Medicine Name</label>
                                <div class="rounded-md border border-gray-200 bg-gray-50 px-4 py-2">
                                    {{ medicine.name }}
                                </div>
                            </div>

                            <div>
                                <label class="mb-1 block text-sm font-medium text-gray-700">Generic Name</label>
                                <div class="rounded-md border border-gray-200 bg-gray-50 px-4 py-2">
                                    {{ medicine.generic_name }}
                                </div>
                            </div>
                        </div>

                        <!-- Row 2 -->
                        <div class="grid grid-cols-1 gap-5 md:grid-cols-2">
                            <div>
                                <label class="mb-1 block text-sm font-medium text-gray-700">Manufacturer</label>
                                <div class="rounded-md border border-gray-200 bg-gray-50 px-4 py-2">
                                    {{ medicine.manufacturer }}
                                </div>
                            </div>

                            <div>
                                <label class="mb-1 block text-sm font-medium text-gray-700">Category</label>
                                <div class="rounded-md border border-gray-200 bg-gray-50 px-4 py-2">
                                    {{ medicine.category }}
                                </div>
                            </div>
                        </div>

                        <!-- Row 3 -->
                        <div class="grid grid-cols-1 gap-5 md:grid-cols-3">
                            <div>
                                <label class="mb-1 block text-sm font-medium text-gray-700">Strength</label>
                                <div class="rounded-md border border-gray-200 bg-gray-50 px-4 py-2">
                                    {{ medicine.strength }}
                                </div>
                            </div>

                            <div>
                                <label class="mb-1 block text-sm font-medium text-gray-700">Unit</label>
                                <div class="rounded-md border border-gray-200 bg-gray-50 px-4 py-2">
                                    {{ medicine.unit }}
                                </div>
                            </div>

                            <div>
                                <label class="mb-1 block text-sm font-medium text-gray-700">Discount</label>
                                <div class="rounded-md border border-gray-200 bg-gray-50 px-4 py-2">{{ medicine.discount }}%</div>
                            </div>
                        </div>

                        <!-- Row 4 -->
                        <div class="grid grid-cols-1 gap-5 md:grid-cols-2">
                            <div>
                                <label class="mb-1 block text-sm font-medium text-gray-700">Purchase Price</label>
                                <div class="rounded-md border border-gray-200 bg-gray-50 px-4 py-2">${{ medicine.purchase_price }}</div>
                            </div>

                            <div>
                                <label class="mb-1 block text-sm font-medium text-gray-700">Selling Price</label>
                                <div class="rounded-md border border-gray-200 bg-gray-50 px-4 py-2">${{ medicine.selling_price }}</div>
                            </div>
                        </div>

                        <!-- Stock Info -->
                        <div>
                            <label class="mb-1 block text-sm font-medium text-gray-700">Stock Status</label>
                            <div class="rounded-md border border-gray-200 bg-gray-50 px-4 py-3 text-center">
                                <span v-if="medicine.stocks.data.length === 0" class="text-gray-500"> No stock records available </span>
                                <!-- Add stock data display here if needed -->
                            </div>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="mt-8 flex justify-end space-x-4 border-t border-gray-200 pt-6">
                        <div class="flex items-center justify-end space-x-5">
                            <Link
                                :href="route('medicines.edit', medicine.id)"
                                as="button"
                                tabindex="0"
                                class="rounded-md bg-green-500 px-8 py-2 text-white"
                            >
                                Edit
                            </Link>
                            <button type="button" @click="destroyItem" class="rounded-md bg-orange-500 px-8 py-2 text-white">Delete</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
<script setup>
import { Head, Link } from '@inertiajs/vue3';

import AppLayout from '@/layouts/AppLayout.vue';

defineProps({
    medicine: Object,
});

const destroyItem = () => {
    if (confirm('Are you sure you want to delete?')) {
        // Inertia.delete(route('medicines.destroy', props.medicine.id));
    }
};
</script>
