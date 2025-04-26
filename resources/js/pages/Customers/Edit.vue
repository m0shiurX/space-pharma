<template>
    <Head title="Manufacturers" />

    <AppLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">Create New Manufacturer</h2>
        </template>

        <div class="mt-8 rounded-lg bg-white/30 py-8">
            <div class="rounded-lg px-4 md:px-8 xl:px-10">
                <form class="" @submit.prevent="updateCustomer">
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
                        <h2 class="text-2xl font-bold">We cant wait to meet you!</h2>
                        <p class="mt-2 text-base">Please fill in the details below so that we can get in contact with you.</p>
                        <div class="mt-6">
                            <BaseInput label="Name" v-model="form.name" :error="form.errors.name" class="" />
                            <BaseInput label="Address" v-model="form.address" :error="form.errors.address" class="" />
                            <BaseInput label="Phone" v-model="form.phone" :error="form.errors.phone" class="" />

                            <div class="mt-8 flex items-center justify-end space-x-5">
                                <Link @click="reset" :href="route('manufacturers.index')" class="rounded-md bg-slate-400 px-8 py-2 text-white"
                                    >Cancel</Link
                                >
                                <button @click="updateCustomer" class="rounded-md bg-orange-500 px-8 py-2 text-white" :disabled="form.processing">
                                    Update
                                </button>
                                <button @click="destroyCustomer" class="rounded-md bg-orange-500 px-8 py-2 text-white" :disabled="form.processing">
                                    Delete
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

const props = defineProps({
    customer: Object,
});

const form = useForm({
    name: props.customer.name,
    address: props.customer.address,
    phone: props.customer.phone,
});

const updateCustomer = () => {
    form.put(route('customers.update', props.customer.id));
};

const destroyCustomer = () => {
    if (confirm('Are you sure you want to delete this customer?')) {
        form.delete(route('customers.destroy', props.customer.id));
    }
};

const reset = () => {
    form.reset();
};
</script>
