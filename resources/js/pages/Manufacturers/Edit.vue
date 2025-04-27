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
                        <!-- Form steps goes here -->
                        <div class="mb-6 rounded-xl border border-orange-100 px-5 py-3">
                            <div class="flex items-center justify-start divide-x-2">
                                <div class="flex items-center pr-2">
                                    <Icon icon="location" class="h-8 w-8 stroke-orange-300" />
                                    <div class="ml-2 flex hidden flex-col">
                                        <span class="text-xs text-slate-400">Step 1/3</span>
                                        <span class="text-sm text-slate-500"> Updating a manufacturer </span>
                                    </div>
                                </div>
                                <div class="flex items-center px-2">
                                    <Icon icon="location" class="h-8 w-8 stroke-orange-300" />
                                    <div class="ml-2 flex flex-col">
                                        <span class="text-xs text-slate-400">Step 2/3</span>
                                        <span class="text-sm text-slate-500"> Updating a manufacturer </span>
                                    </div>
                                </div>
                                <div class="flex items-center pl-2">
                                    <Icon icon="location" class="h-8 w-8 stroke-orange-300" />
                                    <div class="ml-2 flex hidden flex-col">
                                        <span class="text-xs text-slate-400">Step 3/</span>
                                        <span class="text-sm text-slate-500"> Updating a manufacturer </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <h2 class="text-2xl font-bold">Update Manufacturer Information</h2>
                        <p class="mt-2 text-base">Make changes to the manufacturer's details below to ensure everything stays current.</p>

                        <div class="mt-6">
                            <BaseInput label="Name" v-model="form.name" :error="form.errors.name" class="" />
                            <BaseInput label="Location" v-model="form.location" :error="form.errors.location" class="" />
                            <BaseInput label="Contact Name" v-model="form.contact_name" :error="form.errors.contact_name" class="" />
                            <BaseInput label="Contact Tel" v-model="form.contact_tel" :error="form.errors.contact_tel" class="" />

                            <div class="mt-8 flex items-center justify-end space-x-5">
                                <Link @click="reset" :href="route('manufacturers.index')" class="rounded-md bg-slate-400 px-8 py-2 text-white"
                                    >Cancel</Link
                                >
                                <button @click="updateManufacturer" class="rounded-md bg-orange-500 px-8 py-2 text-white" :disabled="form.processing">
                                    Update
                                </button>
                                <button
                                    @click="destroyManufacturer"
                                    class="rounded-md bg-orange-500 px-8 py-2 text-white"
                                    :disabled="form.processing"
                                >
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
    manufacturer: Object,
});

const form = useForm({
    name: props.manufacturer.name,
    location: props.manufacturer.location,
    contact_name: props.manufacturer.contact_name,
    contact_tel: props.manufacturer.contact_tel,
});

const updateManufacturer = () => {
    // form.put(`/manufacturers/${props.manufacturer.id}`);
    form.put(route('manufacturers.update', props.manufacturer.id));
};

const destroyManufacturer = () => {
    if (confirm('Are you sure you want to delete this organization?')) {
        form.delete(route('manufacturers.destroy', props.manufacturer.id));
    }
};

const reset = () => {
    form.reset();
};
</script>
