<template>

    <Head title="Sales" />

    <AppLayout>
        <template #header>
            <h2 class="font-semibold text-gray-800 text-xl leading-tight">Recent Sales</h2>
        </template>

        <div class="bg-white/30 mt-8 py-4 rounded-lg">
            <div class="px-4 md:px-8 xl:px-10">
                <FlashMessages />
            </div>
            <div class="px-4 md:px-8 xl:px-10">
                <div class="flex justify-between items-center">
                    <SearchFilter v-model="form.search" class="mr-4 rounded-lg w-80" @reset="resetSearch">
                    </SearchFilter>

                    <Link
                        class="inline-flex justify-start items-start focus:outline-hidden bg-orange-700 hover:bg-orange-600 mt-4 sm:mt-0 px-6 py-3 rounded-sm focus:ring-2 focus:ring-orange-600 focus:ring-offset-2"
                        :href="route('sales.create')"><span class="font-medium text-sm text-white leading-none">Make a
                        Sale</span>
                    </Link>
                </div>
            </div>
            <div class="px-4 md:px-8 xl:px-10 rounded-lg">
                <div
                    class="mt-5 pb-20 scrollbar-thumb-rounded-full scrollbar-track-rounded-full overflow-auto overflow-y-scroll scrollbar-thin scrollbar-track-orange-300 scrollbar-thumb-orange-700">
                    <table class="w-full whitespace-nowrap table-auto">
                        <thead>
                            <tr tabindex="0"
                                class="focus:outline-hidden bg-white border border-gray-100 rounded-lg h-16 text-gray-500 text-lg">
                                <th class="pl-5 border-gray-100 border-r text-left">Invoice</th>
                                <th class="pl-5 border-gray-100 border-x text-left">Customer</th>
                                <th class="pl-5 border-gray-100 border-x text-left">Total</th>
                                <th class="pl-5 border-gray-100 border-x text-left">Paid</th>
                                <th colspan="2" class="border-gray-100 border-l">Action</th>
                            </tr>
                            <tr class="h-2"></tr>
                        </thead>
                        <tbody class="">
                            <template v-for="sale in props.sales.data" :key="sale.id">
                                <tr tabindex="0"
                                    class="group bg-gray-50 hover:bg-gray-300 border border-gray-100 rounded-sm h-14 transition-colors duration-200 ease-in">
                                    <td class="border-gray-100 border-r">
                                        <div class="flex items-center pt-3 pl-5">
                                            <p class="mr-2 font-bold text-base text-gray-700 capitalize leading-none">
                                                {{ sale.invoice_no }}
                                            </p>
                                        </div>
                                        <div class="flex items-center pt-2 pb-3 pl-5">
                                            <p class="text-base text-gray-400 truncate capitalize leading-none">
                                                {{ sale.sales_date }}
                                            </p>
                                        </div>
                                    </td>
                                    <td class="border-gray-100 border-r">
                                        <div class="flex items-center pt-2 pb-3 pl-5">
                                            <icon icon="user-circle" class="w-4 h-4 stroke-slate-400" />
                                            <p class="ml-1 text-base text-gray-400 leading-none">
                                                {{ sale.customer }}
                                            </p>
                                        </div>
                                    </td>
                                    <td class="border-gray-100 border-r">
                                        <div class="flex items-center pt-2 pb-3 pl-5">
                                            <icon icon="currency" class="w-4 h-4 stroke-slate-400" />
                                            <p class="ml-1 text-base text-gray-400 leading-none">
                                                {{ sale.grand_total }}
                                            </p>
                                        </div>
                                    </td>
                                    <td class="border-gray-100 border-r">
                                        <div class="flex items-center pt-2 pb-3 pl-5">
                                            <p class="ml-1 text-gray-400 text-sm leading-none">
                                                {{ sale.paid_amount }}
                                            </p>
                                        </div>
                                    </td>

                                    <td class="pl-5">
                                        <Link :href="route('sales.show', sale.id)"
                                            class="focus:outline-hidden bg-red-100 hover:bg-red-200 px-5 py-2 rounded-sm text-orange-900 text-sm leading-none focus:ring-2 focus:ring-red-300 focus:ring-offset-2">
                                        See Details
                                        </Link>
                                    </td>
                                    <td>
                                        <div class="relative px-5 pt-2">
                                            <Menu as="div">
                                                <MenuButton>
                                                    <Icon icon="dots" />
                                                </MenuButton>

                                                <MenuItems
                                                    class="right-0 z-30 absolute flex flex-col bg-white shadow-sm mr-2 rounded-md w-24">
                                                    <MenuItem v-slot="{ active }">
                                                    <Link
                                                        class="focus:outline-hidden hover:bg-orange-600 px-4 py-4 rounded-t-md w-full text-xs hover:text-white focus:text-orange-200 cursor-pointer"
                                                        :class="{ 'bg-orange-600 text-white': active }"
                                                        :href="route('sales.edit', sale.id)" as="button">
                                                    Edit
                                                    </Link>
                                                    </MenuItem>
                                                    <MenuItem v-slot="{ active }">
                                                    <button
                                                        class="focus:outline-hidden hover:bg-orange-600 px-4 py-4 rounded-b-md w-full text-xs hover:text-white focus:text-orange-200 cursor-pointer"
                                                        :class="{ 'bg-orange-600 text-white': active }"
                                                        @click="destroyItem(sale.id)">
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
                <Pagination class="mt-5" :links="props.sales.links" />
            </div>
        </div>
    </AppLayout>
</template>
<script setup>
import { watch } from 'vue';
import { Head, useForm, Link } from '@inertiajs/vue3';

import Pagination from '@/Shared/Pagination.vue';
import AppLayout from '@/layouts/AppLayout.vue';
import SearchFilter from '@/Shared/SearchFilter.vue';
import pickBy from 'lodash/pickBy';
import Icon from '@/Shared/Icon.vue';
import debounce from 'lodash/debounce';
import FlashMessages from '@/Shared/FlashMessages.vue';
import { Menu, MenuButton, MenuItems, MenuItem } from '@headlessui/vue';

const props = defineProps({
    sales: Object,
    filters: Object,
});

const form = useForm({
    search: props.filters.search,
});

watch(
    form,
    debounce(() => {
        Inertia.get(route('sales.index'), pickBy(form), {
            preserveState: true,
            replace: true,
        });
    }, 500),
);

const destroyItem = (item) => {
    console.log(item);
    // Inertia.delete(route('sales.destroy', item));
};

const resetSearch = () => {
    form.reset();
};
</script>
