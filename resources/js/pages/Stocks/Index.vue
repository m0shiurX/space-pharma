<template>

    <Head title="Medicines" />

    <AuthLayout>
        <template #header>
            <h2 class="font-semibold text-gray-800 text-xl leading-tight">Medicines List</h2>
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
                        class="inline-flex justify-start items-start bg-orange-700 hover:bg-orange-600 mt-4 sm:mt-0 px-6 py-3 rounded-sm focus:outline-hidden focus:ring-2 focus:ring-orange-600 focus:ring-offset-2"
                        href="#"><span class="font-medium text-sm text-white leading-none">Add to Stock</span>
                    </Link>
                </div>
            </div>
            <div class="px-4 md:px-8 xl:px-10 rounded-lg">
                <div
                    class="mt-5 pb-20 scrollbar-thumb-rounded-full scrollbar-track-rounded-full overflow-auto overflow-y-scroll scrollbar-thin scrollbar-track-orange-300 scrollbar-thumb-orange-700">
                    <table class="w-full whitespace-nowrap table-auto">
                        <thead>
                            <tr tabindex="0"
                                class="bg-white border border-gray-100 rounded-lg h-16 text-gray-500 text-lg focus:outline-hidden">
                                <th class="pl-5 border-gray-100 border-r text-left">Medicine</th>
                                <th class="pl-5 border-gray-100 border-x text-left">Batch</th>
                                <th class="text-right pr-5 border-gray-100 border-x">Stock</th>
                                <th class="border-gray-100 border-l">Action</th>
                            </tr>
                            <tr class="h-3"></tr>
                        </thead>
                        <tbody class="">
                            <template v-for="stock in props.stocks.data" :key="stock.id">
                                <tr tabindex="0"
                                    class="group bg-gray-50 hover:bg-orange-100 border border-gray-100 rounded-sm h-14 transition-colors duration-200 ease-in">
                                    <td class="border-gray-100 border-r">
                                        <div class="flex items-center pt-3 pl-5">
                                            <p class="mr-2 font-semibold text-gray-700 text-lg capitalize leading-none">
                                                {{ stock.medicine }}
                                            </p>
                                        </div>
                                        <div class="flex items-center pt-2 pb-3 pl-5">
                                            <icon icon="manufacturer" class="w-4 h-4 stroke-slate-400" />

                                            <p class="text-gray-400 text-sm truncate capitalize leading-none">
                                                {{ stock.manufacturer }}
                                            </p>
                                        </div>
                                    </td>
                                    <td class="border-gray-100 border-r">
                                        <div class="flex items-center pt-2 pb-3 pl-5">
                                            <icon icon="hash" class="w-4 h-4 stroke-slate-400" />
                                            <p class="ml-1 text-base text-gray-400 leading-none">
                                                {{ stock.batch_id }}
                                            </p>
                                        </div>
                                        <div class="flex items-center pt-2 pb-3 pl-5">
                                            <icon icon="calender" class="w-4 h-4 stroke-slate-400" />
                                            <p class="ml-1 text-base text-gray-400 leading-none">
                                                {{ stock.expiry_date }}
                                            </p>
                                        </div>
                                    </td>
                                    <td class="border-gray-100 border-r">
                                        <div class="flex justify-end items-center pt-2 pr-5 pb-3">
                                            <p class="text-gray-400 text-sm leading-none">
                                                {{ stock.stock }}
                                            </p>
                                        </div>
                                    </td>
                                    <td class="pl-5 text-center">
                                        <Link :href="route('stocks.show', stock.id)"
                                            class="bg-red-100 hover:bg-red-200 px-5 py-2 rounded-sm text-orange-900 text-sm leading-none focus:outline-hidden focus:ring-2 focus:ring-red-300 focus:ring-offset-2">
                                        See History
                                        </Link>
                                    </td>
                                </tr>
                                <tr class="h-1"></tr>
                            </template>
                        </tbody>
                    </table>
                </div>
                <Pagination class="mt-5" :links="props.stocks.links" />
            </div>
        </div>
    </AuthLayout>
</template>
<script setup>
import { watch, ref, onMounted } from 'vue';
import { Head, useForm, Link } from '@inertiajs/vue3';
import { router } from '@inertiajs/vue3';
import Pagination from '@/Shared/Pagination';
import AuthLayout from '@/Layouts/AuthLayout.vue';
import SearchFilter from '@/Shared/SearchFilter.vue';
import pickBy from 'lodash/pickBy';
import Icon from '@/Shared/Icon.vue';
import debounce from 'lodash/debounce';
import FlashMessages from '@/Shared/FlashMessages';
import { Menu, MenuButton, MenuItems, MenuItem } from '@headlessui/vue';

const props = defineProps({
    stocks: Object,
    filters: Object,
});

const form = useForm({
    search: props.filters.search,
});

watch(
    form,
    debounce(() => {
        Inertia.get(route('stocks.index'), pickBy(form), {
            preserveState: true,
            replace: true,
        });
    }, 500),
);

const destroyItem = (item) => {
    console.log(item);
    // Inertia.delete(route('stocks.destroy', item));
};

const resetSearch = () => {
    form.reset();
};
</script>
