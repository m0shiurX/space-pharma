<template>
    <Head title="Customers" />

    <AppLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">Create New Manufacturer</h2>
        </template>

        <div class="mt-8 rounded-lg bg-white/30 py-8">
            <div class="rounded-lg px-4 md:px-8 xl:px-10">
                <form class="" @submit.prevent="saveItem">
                    <div class="w-2xl mx-auto max-w-lg">
                        <!-- Form steps goes here -->
                        <div class="mb-6 rounded-xl border border-orange-100 px-5 py-3">
                            <div class="flex items-center justify-start divide-x-2">
                                <div class="flex items-center pr-2">
                                    <Icon icon="location" class="h-8 w-8 stroke-orange-300" />
                                    <div class="ml-2 flex hidden flex-col">
                                        <span class="text-xs text-slate-400">Step 1/3</span>
                                        <span class="text-sm text-slate-500"> Updating a customer </span>
                                    </div>
                                </div>
                                <div class="flex items-center px-2">
                                    <Icon icon="location" class="h-8 w-8 stroke-orange-300" />
                                    <div class="ml-2 flex flex-col">
                                        <span class="text-xs text-slate-400">Step 2/3</span>
                                        <span class="text-sm text-slate-500"> Updating a customer </span>
                                    </div>
                                </div>
                                <div class="flex items-center pl-2">
                                    <Icon icon="location" class="h-8 w-8 stroke-orange-300" />
                                    <div class="ml-2 flex hidden flex-col">
                                        <span class="text-xs text-slate-400">Step 3/</span>
                                        <span class="text-sm text-slate-500"> Updating a customer </span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <h2 class="hidden text-2xl font-bold">We cant wait to meet you!</h2>
                        <p class="mt-2 hidden text-lg">Please fill in the details below so that we can get in contact with you.</p>
                        <div class="mt-6">
                            <BaseInput label="Name" v-model="form.name" :error="form.errors.name" class="" />
                            <BaseInput label="Generic Name" v-model="form.generic_name" :error="form.errors.generic_name" class="" />
                            <div class="mb-3 w-full bg-orange-100">
                                <v-select
                                    class="h-full"
                                    placeholder="Choose a Manufacturer"
                                    v-model="form.manufacturer_id"
                                    :options="props.manufacturers"
                                    :reduce="(manufacturer) => manufacturer.id"
                                    label="name"
                                />
                            </div>
                            <div class="flex gap-x-2">
                                <BaseInput label="Strength" v-model="form.strength" :error="form.errors.strength" class="flex-1" />
                                <BaseInput label="Unit" v-model="form.unit" :error="form.errors.unit" class="flex-1" />
                            </div>
                            <BaseInput label="Category" v-model="form.category" :error="form.errors.category" class="" />
                            <div class="flex gap-x-2">
                                <BaseInput label="Purchase Price" v-model="form.purchase_price" :error="form.errors.purchase_price" class="flex-1" />
                                <BaseInput label="Selling Price" v-model="form.selling_price" :error="form.errors.selling_price" class="flex-1" />
                                <BaseInput label="Discount (%)" v-model="form.discount" :error="form.errors.discount" class="flex-1" />
                            </div>

                            <div class="mt-8 flex items-center justify-end space-x-5">
                                <Link @click="reset" :href="route('manufacturers.index')" class="rounded-md bg-slate-400 px-8 py-2 text-white"
                                    >Cancel</Link
                                >
                                <button @click="saveItem" class="rounded-md bg-orange-500 px-8 py-2 text-white" :disabled="form.processing">
                                    Save
                                </button>
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
import BaseInput from '@/Shared/BaseInput.vue';
import Icon from '@/Shared/Icon.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import vSelect from 'vue-select';
import 'vue-select/dist/vue-select.css';

const props = defineProps({
    manufacturers: Object,
});

const form = useForm({
    name: '',
    generic_name: '',
    manufacturer_id: '',
    strength: '',
    category: '',
    unit: '',
    purchase_price: '',
    selling_price: '',
    discount: '',
});

const saveItem = () => {
    form.post(route('medicines.store'), {
        preserveScroll: true,
        onSuccess: () => form.reset('password'),
    });
};
const reset = () => {
    form.reset();
};
</script>

<style scoped>
:root {
    --vs-controls-color: #c36e4c;
    --vs-border-color: #c3684c;

    --vs-dropdown-bg: #282c34;
    --vs-dropdown-color: #cc99cd;
    --vs-dropdown-option-color: #cc99cd;

    --vs-selected-bg: #664cc3;
    --vs-selected-color: #eeeeee;

    --vs-search-input-color: #eeeeee;

    --vs-dropdown-option--active-bg: #664cc3;
    --vs-dropdown-option--active-color: #eeeeee;
}
</style>
