<template>

    <Head title="Customers" />

    <AuthLayout>
        <template #header>
            <h2 class="font-semibold text-gray-800 text-xl leading-tight">Sales #{{ invoice_no }}</h2>
        </template>

        <div class="bg-white/30 mt-8 py-8 rounded-lg">
            <div class="px-4 md:px-8 xl:px-10 rounded-lg">
                <!-- Form -->
                <form class="" @submit.prevent="saveItem">
                    <div class="mx-auto w-4xl max-w-4xl">
                        <!-- Invoice header-->
                        <div class="mb-6 px-5 py-3 border border-orange-100 rounded-xl">
                            <div class="flex justify-between items-center divide-x-2">
                                <div class="flex flex-1 items-center pr-2">
                                    <Icon icon="hash" class="w-8 h-10 stroke-orange-300" />
                                    <div class="flex flex-col ml-2">
                                        <span class="font-semibold text-slate-400 text-xs"> #{{ invoice_no }}</span>
                                        <span class="text-slate-500 text-sm"> {{ display_date }} </span>
                                    </div>
                                </div>
                                <div class="flex flex-1 items-center pl-2">
                                    <Icon icon="user-circle" class="w-8 h-8 stroke-orange-300" />
                                    <div class="flex flex-col ml-2">
                                        <span class="font-semibold text-slate-500 text-sm">{{ customer.name }}</span>
                                        <span class="text-slate-400 text-xs">{{ customer.phone }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="mt-6">
                            <!-- Purchase info -->
                            <div class="flex gap-x-2 mb-3">
                                <div class="flex-1">
                                    <label class="block mb-2" for="customer"> Customer</label>
                                    <select
                                        class="bg-orange-50 border border-orange-300 focus:border-orange-400 rounded-md w-full h-10 text-slate-900 appearance-none focus:ring-orange-400"
                                        v-model="form.customer_id" id="customer" required>
                                        <option value="" selected>Select a Customer</option>
                                        <option v-for="customer in props.customers" :key="customer.id"
                                            :value="customer.id">
                                            {{ customer.name }}
                                        </option>
                                    </select>
                                </div>
                                <div class="flex-1">
                                    <label class="block mb-2" for="sales_date">Sales Date</label>
                                    <input id="sales_date" v-model="form.sales_date" type="date"
                                        onkeydown="return false"
                                        class="bg-orange-50 border border-orange-300 focus:border-orange-400 rounded-md w-full h-10 text-slate-900 sm:text-sm appearance-none focus:outline-hidden focus:ring-orange-400"
                                        required disabled />
                                </div>
                            </div>

                            <!-- Medicine search -->

                            <div class="relative flex-1">
                                <label class="block mb-2" for="medicine">Type to search medicine</label>
                                <input name="search" v-model="search" placeholder="Napa" type="text" autocomplete="off"
                                    class="bg-orange-50 mb-5 border border-orange-400 focus:border focus:border-orange-400 rounded-md w-full h-10 placeholder:text-slate-300 focus:ring-orange-600"
                                    @keydown.up.prevent="highlightPrevious" @keydown.down.prevent="highlightNext"
                                    @focus="searchResultShown = true" @keydown.esc="searchResultShown = false"
                                    @input="softResetSearch" @keydown.enter.prevent="selectItem" />
                                <div v-if="search.length > 0"
                                    class="top-9 right-0 absolute mr-3 text-2xl text-gray-600 hover:text-gray-800 cursor-pointer"
                                    @click="resetSearch">
                                    &times;
                                </div>
                                <transition name="fade">
                                    <div v-if="search.length > 0 && searchResultShown"
                                        class="top-20 left-0 z-50 absolute rounded-b-lg rounded-t-sm w-full h-96 overflow-y-auto">
                                        <ul v-if="filteredMedicine.length > 0"
                                            class="bg-orange-100 ring-opacity-5 shadow-lg mt-1 rounded-md w-full text-base overflow-auto ring-1 ring-black focus:outline-hidden">
                                            <li v-for="(medicine, index) in filteredMedicine" :key="medicine.id"
                                                class="relative hover:bg-orange-200 focus:bg-orange-200 py-2 pr-4 pl-10 border-orange-200 border-y hover:border-orange-300 hover:border-y w-full text-slate-900 cursor-pointer"
                                                role="option" tabindex="-1" value="0"
                                                :class="{ 'border-y border-orange-400 bg-orange-200': index === highlightedIndex }"
                                                @click="clickedItem(index)">
                                                <span class="block font-normal capitalize">{{ medicine.name }} - {{
                                                    medicine.strength }}</span>
                                            </li>
                                        </ul>
                                        <ul v-else
                                            class="bg-orange-100 ring-opacity-5 shadow-lg mt-1 rounded-md w-full text-base overflow-auto ring-1 ring-black focus:outline-hidden">
                                            <li
                                                class="relative focus:bg-orange-200 py-2 pr-4 pl-10 w-full text-slate-900 cursor-pointer">
                                                No results found
                                            </li>
                                        </ul>
                                    </div>
                                </transition>
                            </div>

                            <!-- Main table -->
                            <table class="w-full whitespace-nowrap table-auto">
                                <thead>
                                    <tr
                                        class="bg-white border border-gray-100 rounded-lg h-12 text-base text-gray-500 focus:outline-hidden">
                                        <th class="pr-2 pl-5 border-gray-100 border-r text-left">Medicine</th>
                                        <th class="pl-5 border-gray-100 border-x w-32 text-left">BATCH</th>
                                        <th class="pl-5 border-gray-100 border-x w-32 text-left">Qty</th>
                                        <th class="pl-5 border-gray-100 border-x w-32 text-left">MRP</th>
                                        <th class="pr-2 pl-3 border-gray-100 border-x text-left W-20">Disc (%)</th>
                                        <th class="pr-3 pl-5 border-gray-100 border-x w-32 text-left">Total</th>
                                        <th class="border-gray-100 border-l"></th>
                                    </tr>
                                    <tr class="h-2"></tr>
                                </thead>
                                <tbody class="">
                                    <template v-for="(formRow, index) in form.sales_items" :key="index">
                                        <tr
                                            class="group bg-orange-50 hover:bg-orange-100 border border-orange-200 rounded-sm h-10 transition-colors duration-200 ease-in">
                                            <td class="border-gray-100 h-10">
                                                <div class="flex items-center px-2 h-full capitalize">
                                                    {{ formRow.name }} - {{ formRow.strength }}
                                                </div>
                                            </td>
                                            <td class="border-gray-100 w-36 h-10">
                                                <select
                                                    class="text-right bg-orange-50 pr-3 border-0 border-orange-200 border-x focus:border focus:border-orange-400 w-full h-full focus:ring-orange-600"
                                                    v-model="formRow.batch_id" required>
                                                    <option v-for="stock in formRow.stocks" :key="stock.id"
                                                        :value="stock.id">
                                                        {{ stock.batch_id }} - {{ stock.stock }}
                                                    </option>
                                                </select>
                                            </td>
                                            <td class="border-gray-100 w-28 h-10">
                                                <input :disabled="!formRow.batch_id" min="1"
                                                    @focus="$event.target.select()" type="number"
                                                    v-model="formRow.quantity"
                                                    class="text-right bg-orange-50 pr-3 border-0 border-orange-200 focus:border focus:border-orange-400 border-r w-full h-full focus:ring-orange-600" />
                                            </td>
                                            <td class="border-gray-100 w-32 h-10">
                                                <input @focus="$event.target.select()" type="text"
                                                    v-model="formRow.selling_price"
                                                    class="text-right bg-orange-50 pr-3 border-0 border-orange-200 focus:border focus:border-orange-400 border-r w-full h-full focus:ring-orange-600" />
                                            </td>
                                            <td class="border-gray-100 w-20 h-10">
                                                <input @focus="$event.target.select()" type="text"
                                                    v-model="formRow.discount"
                                                    class="text-right bg-orange-50 pr-3 border-0 border-orange-200 focus:border focus:border-orange-400 border-r w-full h-full focus:ring-orange-600" />
                                            </td>
                                            <td class="border-gray-100 w-32 h-10">
                                                <input disabled type="text" v-model="formRow.total_price"
                                                    class="text-right bg-orange-50 pr-3 border-0 border-orange-200 focus:border focus:border-orange-400 w-full h-full focus:ring-orange-600" />
                                            </td>
                                            <td class="p-0 w-12">
                                                <button @click="removeItem(index)" type="button"
                                                    class="inline-flex justify-center bg-red-100 hover:bg-red-200 px-3 py-2.5 w-12 h-full text-center text-orange-900 text-sm leading-none focus:outline-hidden focus:ring-2 focus:ring-red-300 focus:ring-offset-2">
                                                    <Icon icon="close" class="w-5 h-5 stroke-orange-300" />
                                                </button>
                                            </td>
                                        </tr>
                                        <tr class="h-2">
                                            <td colspan="8" v-if="Object.keys(form.errors).length > 0">
                                                <p class="pl-2 text-red-400 text-xs">
                                                    {{ form.errors['sales_items.' + index + '.batch_id'] }}
                                                </p>
                                            </td>
                                        </tr>
                                    </template>
                                </tbody>
                                <tfoot>
                                    <tr
                                        class="group bg-gray-50 hover:bg-gray-300 border border-gray-100 rounded-sm h-10 transition-colors duration-200 ease-in">
                                        <th colspan="5" class="border-gray-100 border-x">
                                            <div class="flex justify-end items-center pr-5">Sub Total</div>
                                        </th>
                                        <th colspan="1" class="border-gray-100 border-r w-12">
                                            <input disabled type="text" v-model="form.sub_total"
                                                class="text-right bg-orange-50 pr-3 border-0 focus:border focus:border-orange-400 w-full h-full focus:ring-orange-600" />
                                        </th>
                                        <th class="w-12 font-light text-xs">BDT</th>
                                    </tr>
                                    <tr
                                        class="group bg-gray-50 hover:bg-gray-300 border border-gray-100 rounded-sm h-10 transition-colors duration-200 ease-in">
                                        <th colspan="5" class="border-gray-100 border-x">
                                            <div class="flex justify-end items-center pr-5">Invoice Discount</div>
                                        </th>
                                        <th colspan="1" class="border-gray-100 border-r w-12">
                                            <input @focus="$event.target.select()" type="text"
                                                v-model="form.invoice_discount"
                                                class="text-right bg-orange-50 pr-3 border-0 focus:border focus:border-orange-400 w-full h-full focus:ring-orange-600" />
                                        </th>
                                        <th class="w-12 font-light text-xs">BDT</th>
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
                                        class="group bg-gray-50 hover:bg-gray-300 border border-gray-100 rounded-sm h-10 transition-colors duration-200 ease-in">
                                        <th colspan="5" class="border-gray-100 border-x">
                                            <div class="flex justify-end items-center pr-5">Grand Total</div>
                                        </th>
                                        <th colspan="1" class="border-gray-100 border-r w-12">
                                            <input disabled type="text" v-model="form.grand_total"
                                                class="text-right bg-orange-50 pr-3 border-0 focus:border focus:border-orange-400 w-full h-full focus:ring-orange-600" />
                                        </th>
                                        <th class="w-12 font-light text-xs">BDT</th>
                                    </tr>
                                    <tr
                                        class="group bg-gray-50 hover:bg-gray-300 border border-gray-100 rounded-sm h-10 transition-colors duration-200 ease-in">
                                        <th colspan="5" class="border-gray-100 border-x">
                                            <div class="flex justify-end items-center pr-5">Paid Total</div>
                                        </th>
                                        <th colspan="1" class="border-gray-100 border-r w-12">
                                            <input @focus="$event.target.select()" type="text"
                                                v-model="form.paid_amount"
                                                class="text-right bg-orange-50 pr-3 border-0 focus:border focus:border-orange-400 w-full h-full focus:ring-orange-600" />
                                        </th>
                                        <th class="w-12 font-light text-xs">BDT</th>
                                    </tr>
                                    <tr
                                        class="group bg-gray-50 hover:bg-gray-300 border border-gray-100 rounded-sm h-10 transition-colors duration-200 ease-in">
                                        <th colspan="5" class="border-gray-100 border-x">
                                            <div class="flex justify-end items-center pr-5">Exchange Total</div>
                                        </th>
                                        <th colspan="1" class="border-gray-100 border-r w-12">
                                            <input type="text" v-model="form.exchange_amount"
                                                class="text-right bg-orange-50 pr-3 border-0 focus:border focus:border-orange-400 w-full h-full focus:ring-orange-600" />
                                        </th>
                                        <th class="w-12 font-light text-xs">BDT</th>
                                    </tr>
                                </tfoot>
                            </table>

                            <!-- Form actions -->
                            <div class="flex flex-row-reverse justify-start items-center gap-x-5 mt-5">
                                <button type="submit" class="bg-orange-500 px-8 py-2 rounded-md text-white"
                                    :disabled="form.processing">Save</button>
                                <button type="button" :disabled="form.processing" @click="saveItem"
                                    class="bg-slate-400 px-8 py-2 rounded-md text-white">
                                    Save & Print
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
import { ref, computed, watch } from 'vue';
import moment from 'moment';
import debounce from 'lodash/debounce';
import axios from 'axios';

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
    let detail = props.customers.find((item) => item.id === id);
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
        txt.length > 1 &&
            axios
                .get(route('sales.medicine'), {
                    params: { query: txt },
                })
                .then((result) => (filteredMedicine.value = result.data));
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
        let item = filteredMedicine.value[highlightedIndex.value];
        selectedMedicine.value = item;
        resetSearch();
    }
};
const clickedItem = (index) => {
    let item = filteredMedicine.value[index];
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
    highlightedIndex.value > 0 && highlightedIndex.value--;
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
            let net_price = Number(item.quantity * item.selling_price).toFixed(2);
            let discount = Number((item.discount * net_price) / 100).toFixed(2);
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
const reset = () => {
    form.sales_items = [];
    form.reset();
};
</script>
