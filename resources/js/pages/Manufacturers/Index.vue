<template>

    <Head title="Manufacturers" />

    <AppLayout>
        <template #header>
            <h2 class="font-semibold text-gray-800 text-xl leading-tight">Manufacturers List</h2>
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
                        :href="route('manufacturers.create')"><span
                        class="font-medium text-sm text-white leading-none">Add
                        Manufacturer</span>
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
                                <th class="pl-5 border-gray-100 border-r text-left">Manufacturer</th>
                                <th class="pl-5 border-gray-100 border-x text-left">Contact</th>
                                <th colspan="2" class="border-gray-100 border-l">Action</th>
                            </tr>
                            <tr class="h-3"></tr>
                        </thead>
                        <tbody class="">
                            <template v-for="manufacturer in props.manufacturers.data" :key="manufacturer.id">
                                <tr tabindex="0"
                                    class="group bg-gray-50 hover:bg-gray-300 border border-gray-100 rounded-sm h-14 transition-colors duration-200 ease-in">
                                    <td class="border-gray-100 border-r">
                                        <div class="flex items-center pt-3 pl-5">
                                            <p class="mr-2 font-medium text-gray-700 text-lg leading-none">{{
                                                manufacturer.name }}</p>
                                        </div>
                                        <div class="flex items-center pt-2 pb-3 pl-5">
                                            <icon icon="location" class="w-4 h-4 stroke-slate-400" />
                                            <p class="ml-1 text-base text-gray-400 truncate leading-none">{{
                                                manufacturer.location }}</p>
                                        </div>
                                    </td>
                                    <td class="border-gray-100 border-r">
                                        <div class="flex items-center pt-3 pl-5">
                                            <p class="mr-2 font-medium text-gray-600 text-lg leading-none">{{
                                                manufacturer.contact_name }}</p>
                                        </div>
                                        <div class="flex items-center pt-2 pb-3 pl-5">
                                            <icon icon="phone" class="w-4 h-4 stroke-slate-400" />
                                            <p class="ml-1 text-base text-gray-400 leading-none">{{
                                                manufacturer.contact_tel }}</p>
                                        </div>
                                    </td>
                                    <td class="pl-5">
                                        <Link :href="route('manufacturers.show', manufacturer.id)"
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
                                                        :href="route('manufacturers.edit', manufacturer.id)"
                                                        as="button">
                                                    Edit
                                                    </Link>
                                                    </MenuItem>
                                                    <MenuItem v-slot="{ active }">
                                                    <button
                                                        class="focus:outline-hidden hover:bg-orange-600 px-4 py-4 rounded-b-md w-full text-xs hover:text-white focus:text-orange-200 cursor-pointer"
                                                        :class="{ 'bg-orange-600 text-white': active }"
                                                        @click="destroyItem(manufacturer.id)">
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
                <Pagination class="mt-5" :links="props.manufacturers.links" />
            </div>
            <div v-if="roles.includes('admin')" class="px-4 md:px-8 xl:px-10 py-12 rounded-lg">
                <form class="flex items-center" @submit.prevent="startImporting">
                    <label class="block">
                        <span class="sr-only">Choose csv file</span>
                        <input @input="importerForm.file = $event.target.files[0]" type="file" accept="application/csv"
                            class="block hover:file:bg-violet-100 file:bg-violet-50 file:mr-4 file:px-4 file:py-2 file:border-0 file:rounded-full w-full file:font-semibold text-slate-500 text-sm file:text-sm file:text-violet-700" />
                    </label>
                    <button
                        class="inline-flex justify-start items-start focus:outline-hidden bg-orange-700 hover:bg-orange-600 px-6 py-2 rounded-sm text-white focus:ring-2 focus:ring-orange-600 focus:ring-offset-2"
                        type="submit">
                        Start Importing
                    </button>
                    <a :href="route('manufacturers.export')"
                        class="inline-flex justify-start items-start focus:outline-hidden bg-orange-700 hover:bg-orange-600 ml-5 px-6 py-2 rounded-sm text-white focus:ring-2 focus:ring-orange-600 focus:ring-offset-2">
                        Export Manufacturers
                    </a>
                </form>
            </div>
        </div>
    </AppLayout>
</template>
<script setup lang="ts">
import { watch, computed } from 'vue';
import { Head, useForm, usePage, Link } from '@inertiajs/vue3';
import Pagination from '@/Shared/Pagination.vue';
import AppLayout from '@/Layouts/AppLayout.vue';
import SearchFilter from '@/Shared/SearchFilter.vue';
import pickBy from 'lodash/pickBy';
import Icon from '@/Shared/Icon.vue';
import debounce from 'lodash/debounce';
import FlashMessages from '@/Shared/FlashMessages.vue';
import { Menu, MenuButton, MenuItems, MenuItem } from '@headlessui/vue';


const page = usePage<SharedData>();
// const user = page.props.auth.user as User;

const roles = computed(() => usePage().props.auth.role);
const props = defineProps({
    manufacturers: Object,
    filters: Object,
});

const form = useForm({
    search: props.filters.search,
});
const importerForm = useForm({
    _method: 'post',
    file: null,
});

const startImporting = () => {
    importerForm.post(route('manufacturers.import'));
};

watch(
    form,
    debounce(() => {
        Inertia.get(route('manufacturers.index'), pickBy(form), { preserveState: true, replace: true });
    }, 500),
);

const destroyItem = (item) => {
    console.log(item);
    // Inertia.delete(route('manufacturers.destroy', item));
};

const resetSearch = () => {
    form.reset();
};
</script>
