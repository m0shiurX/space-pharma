<template>

    <Head title="Manufacturers" />

    <AuthLayout>
        <template #header>
            <h2 class="font-semibold text-gray-800 text-xl leading-tight">Adding a medicine</h2>
        </template>

        <div class="bg-white/30 mt-8 py-8 rounded-lg">
            <div class="px-4 md:px-8 xl:px-10 rounded-lg">
                <form class="" @submit.prevent="updateItem">
                    <div class="mx-auto w-2xl max-w-lg">
                        <!-- Form steps goes here -->
                        <div class="mb-6 px-5 py-3 border border-orange-100 rounded-xl">
                            <div class="flex justify-start items-center divide-x-2">
                                <div class="flex items-center pr-2">
                                    <Icon icon="location" class="w-8 h-8 stroke-slate-300" />
                                    <div class="flex flex-col hidden ml-2">
                                        <span class="text-slate-400 text-xs">Step 1/3</span>
                                        <span class="text-slate-500 text-sm"> Updating a medicine </span>
                                    </div>
                                </div>
                                <div class="flex items-center px-2">
                                    <Icon icon="location" class="w-8 h-8 stroke-orange-300" />
                                    <div class="flex flex-col ml-2">
                                        <span class="text-slate-400 text-xs">Step 2/3</span>
                                        <span class="text-slate-500 text-sm"> Updating a medicine </span>
                                    </div>
                                </div>
                                <div class="flex items-center pl-2">
                                    <Icon icon="location" class="w-8 h-8 stroke-slate-300" />
                                    <div class="flex flex-col hidden ml-2">
                                        <span class="text-slate-400 text-xs">Step 3/</span>
                                        <span class="text-slate-500 text-sm"> Updating a medicine </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <h2 class="hidden font-bold text-2xl">We cant wait to meet you!</h2>
                        <p class="hidden mt-2 text-base">Please fill in the details below so that we can get in contact
                            with
                            you.</p>
                        <div class="mt-6">
                            <BaseInput label="Name" v-model="form.name" :error="form.errors.name" class="" />
                            <BaseInput label="Generic Name" v-model="form.generic_name"
                                :error="form.errors.generic_name" class="" />
                            <BaseInput label="Manufacturer" v-model="form.manufacturer_id"
                                :error="form.errors.manufacturer_id" class="" />
                            <div class="flex gap-x-2">
                                <BaseInput label="Strength" v-model="form.strength" :error="form.errors.strength"
                                    class="flex-1" />
                                <BaseInput label="Unit" v-model="form.unit" :error="form.errors.unit" class="flex-1" />
                            </div>
                            <BaseInput label="Category" v-model="form.category" :error="form.errors.category"
                                class="" />
                            <div class="flex gap-x-2">
                                <BaseInput label="Purchase Price" v-model="form.purchase_price"
                                    :error="form.errors.purchase_price" class="flex-1" />
                                <BaseInput label="Selling Price" v-model="form.selling_price"
                                    :error="form.errors.selling_price" class="flex-1" />
                                <BaseInput label="Discount (%)" v-model="form.discount" :error="form.errors.discount"
                                    class="flex-1" />
                            </div>
                            <div class="flex justify-end items-center space-x-5 mt-8">
                                <Link @click="reset" :href="route('manufacturers.index')"
                                    class="bg-slate-400 px-8 py-2 rounded-md text-white">Cancel</Link>
                                <button @click="updateItem" class="bg-orange-500 px-8 py-2 rounded-md text-white"
                                    :disabled="form.processing">
                                    Update
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </AuthLayout>
</template>
<script setup>
import { Head, Link, useForm } from '@inertiajs/vue3';
import { router } from '@inertiajs/vue3';
import AuthLayout from '@/Layouts/AuthLayout.vue';
import BaseInput from '@/Shared/BaseInput.vue';
import Icon from '@/Shared/Icon.vue';

const props = defineProps({
    medicine: Object,
});

const form = useForm({
    name: props.medicine.name,
    generic_name: props.medicine.generic_name,
    manufacturer_id: props.medicine.manufacturer_id,
    strength: props.medicine.strength,
    category: props.medicine.category,
    unit: props.medicine.unit,
    purchase_price: props.medicine.purchase_price,
    selling_price: props.medicine.selling_price,
    discount: props.medicine.discount,
});

const updateItem = () => {
    form.put(route('medicines.update', props.medicine.id));
};

const reset = () => {
    form.reset();
};
</script>
