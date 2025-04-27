<script setup>
// import InputError from '@/components/InputError.vue';
// import InputLabel from '@/Components/InputLabel.vue';
// import PrimaryButton from '@/Components/PrimaryButton.vue';
// import TextInput from '@/Components/TextInput.vue';
import AppLayout from '@/layouts/AppLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';
import 'vue-select/dist/vue-select.css';

const props = defineProps({
    medicines: Array,
    invoice_no: String,
    initialValues: Object,
});

const form = useForm({
    medicine_id: props.initialValues.medicine_id,
    batch_id: props.initialValues.batch_id,
    quantity: props.initialValues.quantity,
    expiry_date: props.initialValues.expiry_date,
    purchase_price: props.initialValues.purchase_price,
    selling_price: props.initialValues.selling_price,
    invoice_no: props.initialValues.invoice_no,
    supplier: props.initialValues.supplier,
    remarks: props.initialValues.remarks,
});

const submit = () => {
    form.post(route('stocks.store'), {
        preserveScroll: true,
        onSuccess: () => form.reset(),
    });
};
</script>

<template>
    <Head title="Add New Stock" />

    <AppLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">Add New Stock Entry</h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <div class="border-b border-gray-200 bg-white p-6">
                        <form @submit.prevent="submit" class="space-y-6">
                            <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                                <!-- Medicine Selection -->
                                <div>
                                    <label for="medicine_id" class="mb-1 block text-sm font-medium text-gray-700">Select Medicine</label>
                                    <select
                                        v-model="form.medicine_id"
                                        id="medicine_id"
                                        name="medicine_id"
                                        class="block w-full rounded-md border border-orange-400 bg-orange-50 p-2.5 text-gray-700 shadow-sm focus:border-orange-400 focus:ring-2 focus:ring-orange-600"
                                    >
                                        <option value="" disabled>Select a medicine</option>
                                        <option v-for="medicine in medicines" :key="medicine.value" :value="medicine.value">
                                            {{ medicine.label }}
                                        </option>
                                    </select>
                                </div>

                                <!-- Batch ID -->
                                <div>
                                    <label for="batch_id" class="mb-1 block text-sm font-medium text-gray-700">Batch ID</label>
                                    <input
                                        type="text"
                                        v-model="form.batch_id"
                                        id="batch_id"
                                        name="batch_id"
                                        placeholder="Enter Batch ID"
                                        class="block w-full rounded-md border border-orange-400 bg-orange-50 p-2.5 text-gray-700 shadow-sm focus:border-orange-400 focus:ring-2 focus:ring-orange-600"
                                    />
                                </div>

                                <!-- Quantity -->
                                <div>
                                    <label for="quantity" class="mb-1 block text-sm font-medium text-gray-700">Quantity</label>
                                    <input
                                        type="number"
                                        v-model="form.quantity"
                                        id="quantity"
                                        name="quantity"
                                        min="1"
                                        class="block w-full rounded-md border border-orange-400 bg-orange-50 p-2.5 text-gray-700 shadow-sm focus:border-orange-400 focus:ring-2 focus:ring-orange-600"
                                    />
                                </div>

                                <!-- Expiry Date -->
                                <div>
                                    <label for="expiry_date" class="mb-1 block text-sm font-medium text-gray-700">Expiry Date</label>
                                    <input
                                        type="date"
                                        v-model="form.expiry_date"
                                        id="expiry_date"
                                        name="expiry_date"
                                        class="block w-full rounded-md border border-orange-400 bg-orange-50 p-2.5 text-gray-700 shadow-sm focus:border-orange-400 focus:ring-2 focus:ring-orange-600"
                                    />
                                </div>

                                <!-- Purchase Price -->
                                <div>
                                    <label for="purchase_price" class="mb-1 block text-sm font-medium text-gray-700">Purchase Price</label>
                                    <input
                                        type="number"
                                        v-model="form.purchase_price"
                                        id="purchase_price"
                                        name="purchase_price"
                                        min="0"
                                        step="0.01"
                                        class="block w-full rounded-md border border-orange-400 bg-orange-50 p-2.5 text-gray-700 shadow-sm focus:border-orange-400 focus:ring-2 focus:ring-orange-600"
                                    />
                                </div>

                                <!-- Selling Price -->
                                <div>
                                    <label for="selling_price" class="mb-1 block text-sm font-medium text-gray-700">Selling Price</label>
                                    <input
                                        type="number"
                                        v-model="form.selling_price"
                                        id="selling_price"
                                        name="selling_price"
                                        min="0"
                                        step="0.01"
                                        class="block w-full rounded-md border border-orange-400 bg-orange-50 p-2.5 text-gray-700 shadow-sm focus:border-orange-400 focus:ring-2 focus:ring-orange-600"
                                    />
                                </div>

                                <!-- Supplier -->
                                <div class="md:col-span-2">
                                    <label for="supplier" class="mb-1 block text-sm font-medium text-gray-700">Supplier</label>
                                    <input
                                        type="text"
                                        v-model="form.supplier"
                                        id="supplier"
                                        name="supplier"
                                        placeholder="Enter Supplier Name"
                                        class="block w-full rounded-md border border-orange-400 bg-orange-50 p-2.5 text-gray-700 shadow-sm focus:border-orange-400 focus:ring-2 focus:ring-orange-600"
                                    />
                                </div>

                                <!-- Remarks -->
                                <div class="md:col-span-2">
                                    <label for="remarks" class="mb-1 block text-sm font-medium text-gray-700">Remarks</label>
                                    <textarea
                                        v-model="form.remarks"
                                        id="remarks"
                                        name="remarks"
                                        rows="3"
                                        placeholder="Enter any remarks"
                                        class="block w-full rounded-md border border-orange-400 bg-orange-50 p-2.5 text-gray-700 shadow-sm focus:border-orange-400 focus:ring-2 focus:ring-orange-600"
                                    ></textarea>
                                </div>
                            </div>

                            <!-- Action Buttons -->
                            <div class="flex justify-end space-x-4 pt-6">
                                <Link
                                    :href="route('stocks.index')"
                                    class="rounded-md border border-orange-400 bg-white px-4 py-2 text-sm font-medium text-orange-600 shadow-sm hover:bg-orange-50 focus:outline-none focus:ring-2 focus:ring-orange-600"
                                >
                                    Cancel
                                </Link>
                                <button
                                    :disabled="form.processing"
                                    class="rounded-md bg-orange-500 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-orange-600 focus:outline-none focus:ring-2 focus:ring-orange-600"
                                >
                                    Save Stock Entry
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
