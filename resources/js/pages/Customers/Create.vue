<template>

    <Head title="Customers" />

    <AuthLayout>
        <template #header>
            <h2 class="font-semibold text-gray-800 text-xl leading-tight">Create New Manufacturer</h2>
        </template>

        <div class="bg-white/30 mt-8 py-8 rounded-lg">
            <div class="px-4 md:px-8 xl:px-10 rounded-lg">
                <form class="" @submit.prevent="saveCustomers">
                    <div class="mx-auto w-2xl max-w-lg">
                        <!-- Form steps goes here -->
                        <div class="mb-6 px-5 py-3 border border-orange-100 rounded-xl">
                            <div class="flex justify-start items-center divide-x-2">
                                <div class="flex items-center pr-2">
                                    <Icon icon="location" class="w-8 h-8 stroke-orange-300" />
                                    <div class="flex flex-col hidden ml-2">
                                        <span class="text-slate-400 text-xs">Step 1/3</span>
                                        <span class="text-slate-500 text-sm"> Updating a customer </span>
                                    </div>
                                </div>
                                <div class="flex items-center px-2">
                                    <Icon icon="location" class="w-8 h-8 stroke-orange-300" />
                                    <div class="flex flex-col ml-2">
                                        <span class="text-slate-400 text-xs">Step 2/3</span>
                                        <span class="text-slate-500 text-sm"> Updating a customer </span>
                                    </div>
                                </div>
                                <div class="flex items-center pl-2">
                                    <Icon icon="location" class="w-8 h-8 stroke-orange-300" />
                                    <div class="flex flex-col hidden ml-2">
                                        <span class="text-slate-400 text-xs">Step 3/</span>
                                        <span class="text-slate-500 text-sm"> Updating a customer </span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <h2 class="font-bold text-2xl">We cant wait to meet you!</h2>
                        <p class="mt-2 text-lg">Please fill in the details below so that we can get in contact with you.
                        </p>
                        <div class="mt-6">
                            <BaseInput label="Name" v-model="form.name" :error="form.errors.name" class="" />
                            <BaseInput label="Location" v-model="form.address" :error="form.errors.address" class="" />
                            <BaseInput label="Contact Tel" v-model="form.phone" :error="form.errors.phone" class="" />

                            <div class="flex justify-end items-center space-x-5">
                                <Link @click="reset" :href="route('customers.index')"
                                    class="bg-slate-400 px-8 py-2 rounded-md text-white">Cancel</Link>
                                <button @click="saveCustomers" class="bg-orange-500 px-8 py-2 rounded-md text-white"
                                    :disabled="form.processing">
                                    Save
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

const form = useForm({
    name: '',
    address: '',
    phone: '',
});

const saveCustomers = () => {
    form.post(route('customers.store'), {
        preserveScroll: true,
        onSuccess: () => form.reset('password'),
    });
};
const reset = () => {
    form.reset();
};
</script>
