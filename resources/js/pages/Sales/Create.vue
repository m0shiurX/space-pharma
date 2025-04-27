<template>
    <Head title="Customers" />

    <AppLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">Sales #{{ invoice_no }}</h2>
        </template>

        <div class="mt-8 rounded-lg bg-white/30 py-8">
            <div class="rounded-lg px-4 md:px-8 xl:px-10">
                <!-- Form -->
                <form class="" @submit.prevent="saveItem">
                    <div class="w-4xl mx-auto max-w-4xl">
                        <!-- Invoice header-->
                        <div class="mb-6 rounded-xl border border-orange-100 px-5 py-3">
                            <div class="flex items-center justify-between divide-x-2">
                                <div class="flex flex-1 items-center pr-2">
                                    <Icon icon="hash" class="h-10 w-8 stroke-orange-300" />
                                    <div class="ml-2 flex flex-col">
                                        <span class="text-xs font-semibold text-slate-400"> #{{ invoice_no }}</span>
                                        <span class="text-sm text-slate-500"> {{ display_date }} </span>
                                    </div>
                                </div>
                                <div class="flex flex-1 items-center pl-2">
                                    <Icon icon="user-circle" class="h-8 w-8 stroke-orange-300" />
                                    <div class="ml-2 flex flex-col">
                                        <span class="text-sm font-semibold text-slate-500">{{ customer.name }}</span>
                                        <span class="text-xs text-slate-400">{{ customer.phone }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="mt-6">
                            <!-- Purchase info -->
                            <div class="mb-3 flex gap-x-2">
                                <div class="flex-1">
                                    <label class="mb-2 block" for="customer"> Customer</label>
                                    <select
                                        class="h-10 w-full appearance-none rounded-md border border-orange-300 bg-orange-50 ps-2 text-slate-900 focus:border-orange-400 focus:ring-orange-400"
                                        v-model="form.customer_id"
                                        id="customer"
                                        required
                                    >
                                        <option value="" selected>Select a Customer</option>
                                        <option v-for="customer in props.customers" :key="customer.id" :value="customer.id">
                                            {{ customer.name }}
                                        </option>
                                    </select>
                                </div>
                                <div class="flex-1">
                                    <label class="mb-2 block" for="sales_date">Sales Date</label>
                                    <input
                                        id="sales_date"
                                        v-model="form.sales_date"
                                        type="date"
                                        onkeydown="return false"
                                        class="focus:outline-hidden h-10 w-full appearance-none rounded-md border border-orange-300 bg-orange-50 ps-2 text-slate-900 focus:border-orange-400 focus:ring-orange-400 sm:text-sm"
                                        required
                                        disabled
                                    />
                                </div>
                            </div>

                            <!-- Medicine search -->

                            <div class="relative flex-1">
                                <label class="mb-2 block" for="medicine">Type to search medicine</label>
                                <input
                                    name="search"
                                    v-model="search"
                                    placeholder="Napa"
                                    type="text"
                                    autocomplete="off"
                                    class="mb-5 h-10 w-full rounded-md border border-orange-400 bg-orange-50 ps-2 placeholder:text-slate-300 focus:border focus:border-orange-400 focus:ring-orange-600"
                                    @keydown.up.prevent="highlightPrevious"
                                    @keydown.down.prevent="highlightNext"
                                    @focus="searchResultShown = true"
                                    @keydown.esc="searchResultShown = false"
                                    @input="softResetSearch"
                                    @keydown.enter.prevent="selectItem"
                                />
                                <div
                                    v-if="search.length > 0"
                                    class="absolute right-0 top-9 mr-3 cursor-pointer text-2xl text-gray-600 hover:text-gray-800"
                                    @click="resetSearch"
                                >
                                    &times;
                                </div>
                                <transition name="fade">
                                    <div
                                        v-if="search.length > 0 && searchResultShown"
                                        class="absolute left-0 top-20 z-50 h-96 w-full overflow-y-auto rounded-b-lg rounded-t-sm"
                                    >
                                        <ul
                                            v-if="filteredMedicine.length > 0"
                                            class="focus:outline-hidden mt-1 w-full overflow-auto rounded-md bg-orange-100 text-base shadow-lg ring-1 ring-black ring-opacity-5"
                                        >
                                            <li
                                                v-for="(medicine, index) in filteredMedicine"
                                                :key="medicine.id"
                                                class="relative w-full cursor-pointer border-y border-orange-200 py-2 pl-10 pr-4 text-slate-900 hover:border-y hover:border-orange-300 hover:bg-orange-200 focus:bg-orange-200"
                                                role="option"
                                                tabindex="-1"
                                                value="0"
                                                :class="{ 'border-y border-orange-400 bg-orange-200': index === highlightedIndex }"
                                                @click="clickedItem(index)"
                                            >
                                                <span class="block font-normal capitalize">{{ medicine.name }} - {{ medicine.strength }}</span>
                                            </li>
                                        </ul>
                                        <ul
                                            v-else
                                            class="focus:outline-hidden mt-1 w-full overflow-auto rounded-md bg-orange-100 text-base shadow-lg ring-1 ring-black ring-opacity-5"
                                        >
                                            <li class="relative w-full cursor-pointer py-2 pl-10 pr-4 text-slate-900 focus:bg-orange-200">
                                                No results found
                                            </li>
                                        </ul>
                                    </div>
                                </transition>
                            </div>

                            <!-- Main table -->
                            <table class="w-full table-auto whitespace-nowrap">
                                <thead>
                                    <tr class="focus:outline-hidden h-12 rounded-lg border border-gray-100 bg-white text-base text-gray-500">
                                        <th class="border-r border-gray-100 pl-5 pr-2 text-left">Medicine</th>
                                        <th class="w-32 border-x border-gray-100 pl-5 text-left">BATCH</th>
                                        <th class="w-32 border-x border-gray-100 pl-5 text-left">Qty</th>
                                        <th class="w-32 border-x border-gray-100 pl-5 text-left">MRP</th>
                                        <th class="W-20 border-x border-gray-100 pl-3 pr-2 text-left">Disc (%)</th>
                                        <th class="w-32 border-x border-gray-100 pl-5 pr-3 text-left">Total</th>
                                        <th class="border-l border-gray-100"></th>
                                    </tr>
                                    <tr class="h-2"></tr>
                                </thead>
                                <tbody class="">
                                    <template v-for="(formRow, index) in form.sales_items" :key="index">
                                        <tr
                                            class="group h-10 rounded-sm border border-orange-200 bg-orange-50 transition-colors duration-200 ease-in hover:bg-orange-100"
                                        >
                                            <td class="h-10 border-gray-100">
                                                <div class="flex h-full items-center px-2 capitalize">
                                                    {{ formRow.name }} - {{ formRow.strength }}
                                                </div>
                                            </td>
                                            <td class="h-10 w-36 border-gray-100">
                                                <select
                                                    class="h-full w-full border-0 border-x border-orange-200 bg-orange-50 pr-3 text-right focus:border focus:border-orange-400 focus:ring-orange-600"
                                                    v-model="formRow.batch_id"
                                                    required
                                                >
                                                    <option v-for="stock in formRow.stocks" :key="stock.id" :value="stock.id">
                                                        {{ stock.batch_id }} - {{ stock.stock }}
                                                    </option>
                                                </select>
                                            </td>
                                            <td class="h-10 w-28 border-gray-100">
                                                <input
                                                    :disabled="!formRow.batch_id"
                                                    min="1"
                                                    @focus="$event.target.select()"
                                                    type="number"
                                                    v-model="formRow.quantity"
                                                    class="h-full w-full border-0 border-r border-orange-200 bg-orange-50 pr-3 text-right focus:border focus:border-orange-400 focus:ring-orange-600"
                                                />
                                            </td>
                                            <td class="h-10 w-32 border-gray-100">
                                                <input
                                                    @focus="$event.target.select()"
                                                    type="text"
                                                    v-model="formRow.selling_price"
                                                    class="h-full w-full border-0 border-r border-orange-200 bg-orange-50 pr-3 text-right focus:border focus:border-orange-400 focus:ring-orange-600"
                                                />
                                            </td>
                                            <td class="h-10 w-20 border-gray-100">
                                                <input
                                                    @focus="$event.target.select()"
                                                    type="text"
                                                    v-model="formRow.discount"
                                                    class="h-full w-full border-0 border-r border-orange-200 bg-orange-50 pr-3 text-right focus:border focus:border-orange-400 focus:ring-orange-600"
                                                />
                                            </td>
                                            <td class="h-10 w-32 border-gray-100">
                                                <input
                                                    disabled
                                                    type="text"
                                                    v-model="formRow.total_price"
                                                    class="h-full w-full border-0 border-orange-200 bg-orange-50 pr-3 text-right focus:border focus:border-orange-400 focus:ring-orange-600"
                                                />
                                            </td>
                                            <td class="w-12 p-0">
                                                <button
                                                    @click="removeItem(index)"
                                                    type="button"
                                                    class="focus:outline-hidden inline-flex h-full w-12 justify-center bg-red-100 px-3 py-2.5 text-center text-sm leading-none text-orange-900 hover:bg-red-200 focus:ring-2 focus:ring-red-300 focus:ring-offset-2"
                                                >
                                                    <Icon icon="close" class="h-5 w-5 stroke-orange-300" />
                                                </button>
                                            </td>
                                        </tr>
                                        <tr class="h-2">
                                            <td colspan="8" v-if="Object.keys(form.errors).length > 0">
                                                <p class="pl-2 text-xs text-red-400">
                                                    {{ form.errors['sales_items.' + index + '.batch_id'] }}
                                                </p>
                                            </td>
                                        </tr>
                                    </template>
                                </tbody>
                                <tfoot>
                                    <tr
                                        class="group h-10 rounded-sm border border-gray-100 bg-gray-50 transition-colors duration-200 ease-in hover:bg-gray-300"
                                    >
                                        <th colspan="5" class="border-x border-gray-100">
                                            <div class="flex items-center justify-end pr-5">Sub Total</div>
                                        </th>
                                        <th colspan="1" class="w-12 border-r border-gray-100">
                                            <input
                                                disabled
                                                type="text"
                                                v-model="form.sub_total"
                                                class="h-full w-full border-0 bg-orange-50 pr-3 text-right focus:border focus:border-orange-400 focus:ring-orange-600"
                                            />
                                        </th>
                                        <th class="w-12 text-xs font-light">BDT</th>
                                    </tr>
                                    <tr
                                        class="group h-10 rounded-sm border border-gray-100 bg-gray-50 transition-colors duration-200 ease-in hover:bg-gray-300"
                                    >
                                        <th colspan="5" class="border-x border-gray-100">
                                            <div class="flex items-center justify-end pr-5">Invoice Discount</div>
                                        </th>
                                        <th colspan="1" class="w-12 border-r border-gray-100">
                                            <input
                                                @focus="$event.target.select()"
                                                type="text"
                                                v-model="form.invoice_discount"
                                                class="h-full w-full border-0 bg-orange-50 pr-3 text-right focus:border focus:border-orange-400 focus:ring-orange-600"
                                            />
                                        </th>
                                        <th class="w-12 text-xs font-light">BDT</th>
                                    </tr>
                                    <!-- <tr
                                        class="group bg-gray-50 hover:bg-gray-300 border border-gray-100 rounded-sm h-10 transition-colors duration-200 ease-in"
                                    >
                                        <th colspan="5" class="border-gray-100 border-x">
                                            <div class="flex justify-end items-center pr-5">VAT</div>
                                        </th>
                                        <th colspan="1" class="border-gray-100 border-r w-12">
                                            <input
                                                disabled
                                                type="text"
                                                v-model="form.vat"
                                                class="text-right bg-orange-50 pr-3 border-0 focus:border focus:border-orange-400 w-full h-full focus:ring-orange-600"
                                            />
                                        </th>
                                        <th class="w-12 font-light text-xs">%</th>
                                    </tr> -->
                                    <tr
                                        class="group h-10 rounded-sm border border-gray-100 bg-gray-50 transition-colors duration-200 ease-in hover:bg-gray-300"
                                    >
                                        <th colspan="5" class="border-x border-gray-100">
                                            <div class="flex items-center justify-end pr-5">Grand Total</div>
                                        </th>
                                        <th colspan="1" class="w-12 border-r border-gray-100">
                                            <input
                                                disabled
                                                type="text"
                                                v-model="form.grand_total"
                                                class="h-full w-full border-0 bg-orange-50 pr-3 text-right focus:border focus:border-orange-400 focus:ring-orange-600"
                                            />
                                        </th>
                                        <th class="w-12 text-xs font-light">BDT</th>
                                    </tr>
                                    <tr
                                        class="group h-10 rounded-sm border border-gray-100 bg-gray-50 transition-colors duration-200 ease-in hover:bg-gray-300"
                                    >
                                        <th colspan="5" class="border-x border-gray-100">
                                            <div class="flex items-center justify-end pr-5">Paid Total</div>
                                        </th>
                                        <th colspan="1" class="w-12 border-r border-gray-100">
                                            <input
                                                @focus="$event.target.select()"
                                                type="text"
                                                v-model="form.paid_amount"
                                                class="h-full w-full border-0 bg-orange-50 pr-3 text-right focus:border focus:border-orange-400 focus:ring-orange-600"
                                            />
                                        </th>
                                        <th class="w-12 text-xs font-light">BDT</th>
                                    </tr>
                                    <tr
                                        class="group h-10 rounded-sm border border-gray-100 bg-gray-50 transition-colors duration-200 ease-in hover:bg-gray-300"
                                    >
                                        <th colspan="5" class="border-x border-gray-100">
                                            <div class="flex items-center justify-end pr-5">Exchange Total</div>
                                        </th>
                                        <th colspan="1" class="w-12 border-r border-gray-100">
                                            <input
                                                type="text"
                                                v-model="form.exchange_amount"
                                                class="h-full w-full border-0 bg-orange-50 pr-3 text-right focus:border focus:border-orange-400 focus:ring-orange-600"
                                            />
                                        </th>
                                        <th class="w-12 text-xs font-light">BDT</th>
                                    </tr>
                                </tfoot>
                            </table>

                            <!-- Form actions -->
                            <div class="mt-5 flex flex-row-reverse items-center justify-start gap-x-5">
                                <button type="submit" class="rounded-md bg-orange-500 px-8 py-2 text-white" :disabled="form.processing">Save</button>
                                <button
                                    type="button"
                                    :disabled="form.processing"
                                    @click="saveItem"
                                    class="rounded-md bg-slate-400 px-8 py-2 text-white"
                                >
                                    Save & Print
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
import { Head, useForm } from '@inertiajs/vue3';

import AppLayout from '@/layouts/AppLayout.vue';
import Icon from '@/Shared/Icon.vue';
import axios from 'axios';
import debounce from 'lodash/debounce';
import moment from 'moment';
import { computed, ref, watch } from 'vue';

const props = defineProps({
    invoice_no: String,
    customers: Object,
});
const form = useForm({
    invoice_no: props.invoice_no,
    sales_date: moment().format('YYYY-MM-DD'),
    customer_id: 1,
    sub_total: 0,
    vat: 0,
    invoice_discount: 0,
    grand_total: 0,
    paid_amount: 0,
    exchange_amount: 0,
    sales_items: [],
});

// Purchase date
const display_date = computed({
    get() {
        if (moment(form.sales_date).isValid()) {
            return moment(form.sales_date).format('LL');
        } else {
            return moment().format('LL');
        }
    },
});

// Customers
const customer = ref({
    id: 1,
    name: 'Select a Customer',
    phone: '+8801 XXX XXXXXX',
});

const changeCustomer = (id) => {
    const detail = props.customers.find((item) => item.id === id);
    if (detail) {
        customer.value = detail;
    }
};

// :max="formRow.batch_id ? formRow.stocks[formRow.batch_id].stock : 0"
// const getMaxStock = (medicine, batch_id, index) => {
//     let selectedStock = medicine.stocks.filter((stock) => {
//         return (stock.batch_id = batch_id);
//     });
//     console.log(selectedStock);
//     return selectedStock.stock;
// };

watch(
    () => form.customer_id,
    (customer_id) => changeCustomer(customer_id),
);

// Medicines

const search = ref('');
const filteredMedicine = ref([]);
const selectedMedicine = ref();

watch(
    search,
    debounce((txt) => {
        if (txt.length > 1) {
            axios
                .get(route('sales.medicine'), {
                    params: { query: txt },
                })
                .then((result) => (filteredMedicine.value = result.data));
        }
    }, 500),
);

const searchResultShown = ref(false);
const highlightedIndex = ref(0);

const resetSearch = () => {
    search.value = '';
    highlightedIndex.value = 0;
};
const softResetSearch = () => {
    searchResultShown.value = true;
    highlightedIndex.value = 0;
};

const selectItem = () => {
    if (filteredMedicine.value.length > 0) {
        const item = filteredMedicine.value[highlightedIndex.value];
        selectedMedicine.value = item;
        resetSearch();
    }
};
const clickedItem = (index) => {
    const item = filteredMedicine.value[index];
    selectedMedicine.value = item;
    resetSearch();
};
const highlightNext = () => {
    if (highlightedIndex.value < filteredMedicine.value.length - 1) {
        highlightedIndex.value++;
    } else {
        highlightedIndex.value = 0;
    }
};
const highlightPrevious = () => {
    if (highlightedIndex.value > 0) {
        highlightedIndex.value--;
    }
};

// Manage table rows with form
watch(selectedMedicine, (item) => {
    item.total_price = 0;
    item.quantity = 0;
    form.sales_items.push(item);
});

// Calculate fields
watch(
    () => form.sales_items,
    (items) => {
        items.map((item) => {
            const net_price = Number(item.quantity * item.selling_price).toFixed(2);
            const discount = Number((item.discount * net_price) / 100).toFixed(2);
            return (item.total_price = Number(net_price - discount).toFixed(2));
        });
    },
    { deep: true },
);

// Sub total
form.sub_total = computed({
    get() {
        return Number(form.sales_items.reduce((accumulator, current) => accumulator + parseFloat(current.total_price), 0).toFixed(2));
    },
});

// Purchase date
form.grand_total = computed({
    get() {
        if (form.sales_items.length == 0) return 0;
        if (!isNaN(form.invoice_discount) && form.invoice_discount > 0) {
            return Number(Math.round(form.sub_total - form.invoice_discount)).toFixed(2);
        } else {
            return Math.round(form.sub_total);
        }
    },
});

form.exchange_amount = computed({
    get() {
        if (!isNaN(form.paid_amount) && form.paid_amount > 0) {
            return Number(form.grand_total - form.paid_amount).toFixed(2);
        } else {
            return form.grand_total;
        }
    },
});

const removeItem = (index) => {
    form.sales_items.splice(index, 1);
};

// Form Actions
const saveItem = () => {
    form.post(route('sales.store'), {
        preserveScroll: true,
    });
};
</script>
