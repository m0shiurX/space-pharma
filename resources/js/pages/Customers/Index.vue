<template>
    <Head title="Customers" />

    <AppLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">Customers List</h2>
        </template>

        <div class="mt-8 rounded-lg bg-white/30 py-4">
            <div class="px-4 md:px-8 xl:px-10">
                <FlashMessages />
            </div>
            <div class="px-4 md:px-8 xl:px-10">
                <div class="flex items-center justify-between">
                    <SearchFilter v-model="form.search" class="mr-4 w-80 rounded-lg" @reset="resetSearch"> </SearchFilter>

                    <Link
                        class="focus:outline-hidden mt-4 inline-flex items-start justify-start rounded-sm bg-orange-700 px-6 py-3 hover:bg-orange-600 focus:ring-2 focus:ring-orange-600 focus:ring-offset-2 sm:mt-0"
                        :href="route('customers.create')"
                        ><span class="text-sm font-medium leading-none text-white">Add Customer</span>
                    </Link>
                </div>
            </div>
            <div class="rounded-lg px-4 md:px-8 xl:px-10">
                <div
                    class="scrollbar-thumb-rounded-full scrollbar-track-rounded-full scrollbar-thin scrollbar-track-orange-300 scrollbar-thumb-orange-700 mt-5 overflow-auto overflow-y-scroll pb-20"
                >
                    <table class="w-full table-auto whitespace-nowrap">
                        <thead>
                            <tr tabindex="0" class="focus:outline-hidden h-16 rounded-lg border border-gray-100 bg-white text-lg text-gray-500">
                                <th class="border-r border-gray-100 pl-5 text-left">Customer</th>
                                <th class="border-x border-gray-100 pl-5 text-left">Contact</th>
                                <th colspan="2" class="border-l border-gray-100">Action</th>
                            </tr>
                            <tr class="h-3"></tr>
                        </thead>
                        <tbody class="">
                            <template v-for="customer in props.customers.data" :key="customer.id">
                                <tr
                                    tabindex="0"
                                    class="group h-14 rounded-sm border border-gray-100 bg-gray-50 transition-colors duration-200 ease-in hover:bg-gray-300"
                                >
                                    <td class="border-r border-gray-100">
                                        <div class="flex items-center pl-5 pt-3">
                                            <p class="mr-2 text-lg font-medium leading-none text-gray-700">
                                                {{ customer.name }}
                                            </p>
                                        </div>
                                        <div class="flex items-center pb-3 pl-5 pt-2">
                                            <icon icon="location" class="h-4 w-4 stroke-slate-400" />
                                            <p class="ml-1 truncate text-base leading-none text-gray-400">
                                                {{ customer.address }}
                                            </p>
                                        </div>
                                    </td>
                                    <td class="border-r border-gray-100">
                                        <div class="flex items-center pb-3 pl-5 pt-2">
                                            <icon icon="phone" class="h-4 w-4 stroke-slate-400" />
                                            <p class="ml-1 text-base leading-none text-gray-400">
                                                {{ customer.phone }}
                                            </p>
                                        </div>
                                    </td>
                                    <td class="pl-5">
                                        <Link
                                            :href="route('customers.show', customer.id)"
                                            class="focus:outline-hidden rounded-sm bg-red-100 px-5 py-2 text-sm leading-none text-orange-900 hover:bg-red-200 focus:ring-2 focus:ring-red-300 focus:ring-offset-2"
                                        >
                                            See Details
                                        </Link>
                                    </td>
                                    <td>
                                        <div class="relative px-5 pt-2">
                                            <Menu as="div">
                                                <MenuButton>
                                                    <Icon icon="dots" />
                                                </MenuButton>

                                                <MenuItems class="absolute right-0 z-30 mr-2 flex w-24 flex-col rounded-md bg-white shadow-sm">
                                                    <MenuItem v-slot="{ active }">
                                                        <Link
                                                            class="focus:outline-hidden w-full cursor-pointer rounded-t-md px-4 py-4 text-xs hover:bg-orange-600 hover:text-white focus:text-orange-200"
                                                            :class="{ 'bg-orange-600 text-white': active }"
                                                            :href="route('customers.edit', customer.id)"
                                                            as="button"
                                                        >
                                                            Edit
                                                        </Link>
                                                    </MenuItem>
                                                    <MenuItem v-slot="{ active }">
                                                        <button
                                                            class="focus:outline-hidden w-full cursor-pointer rounded-b-md px-4 py-4 text-xs hover:bg-orange-600 hover:text-white focus:text-orange-200"
                                                            :class="{ 'bg-orange-600 text-white': active }"
                                                            @click="destroyItem(customer.id)"
                                                        >
                                                            Delete
                                                        </button>
                                                    </MenuItem>
                                                </MenuItems>
                                            </Menu>
                                        </div>
                                    </td>
                                </tr>
                                <tr class="h-1"></tr>
                            </template>
                        </tbody>
                    </table>
                </div>
                <Pagination class="mt-5" :links="props.customers.links" />
            </div>
        </div>
    </AppLayout>
</template>
<script setup>
import AppLayout from '@/layouts/AppLayout.vue';
import FlashMessages from '@/Shared/FlashMessages.vue';
import Icon from '@/Shared/Icon.vue';
import Pagination from '@/Shared/Pagination.vue';
import SearchFilter from '@/Shared/SearchFilter.vue';
import { Menu, MenuButton, MenuItem, MenuItems } from '@headlessui/vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import debounce from 'lodash/debounce';
import pickBy from 'lodash/pickBy';
import { watch } from 'vue';

const props = defineProps({
    customers: Object,
    filters: Object,
});

const form = useForm({
    search: props.filters.search,
});

watch(
    form,
    debounce(() => {
        Inertia.get(route('customers.index'), pickBy(form), {
            preserveState: true,
            replace: true,
        });
    }, 500),
);

const destroyItem = (item) => {
    console.log(item);
    // Inertia.delete(route('customers.destroy', item));
};

const resetSearch = () => {
    form.reset();
};
</script>
