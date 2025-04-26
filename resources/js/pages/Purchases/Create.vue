<template>
    <Head title="Customers" />

    <AppLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">Purchase #{{ invoice_no }}</h2>
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
                                    <Icon icon="manufacturer" class="h-8 w-8 stroke-orange-300" />
                                    <div class="ml-2 flex flex-col">
                                        <span class="text-sm font-semibold text-slate-500">{{ manufacturer.name }}</span>
                                        <span class="text-xs text-slate-400">{{ manufacturer.location }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="mt-6">
                            <!-- Purchase info -->
                            <div class="mb-3 flex gap-x-2">
                                <div class="flex-1">
                                    <div class="mb-2 max-w-full">
                                        <label class="mb-2 block" for="manufacturer"> Manufacturer</label>
                                        <v-select
                                            class="h-full bg-orange-100"
                                            placeholder="Choose a Manufacturer"
                                            v-model.number="form.manufacturer_id"
                                            :options="props.manufacturers"
                                            :reduce="(manufacturer) => manufacturer.id"
                                            label="name"
                                        />
                                    </div>
                                </div>
                                <div class="flex-1">
                                    <label class="mb-2 block" for="purchase_date">Purchase Date</label>
                                    <input
                                        id="purchase_date"
                                        v-model="form.purchase_date"
                                        type="date"
                                        onkeydown="return false"
                                        class="focus:outline-hidden h-10 w-full appearance-none rounded-md border border-orange-300 bg-orange-50 text-slate-900 focus:border-orange-400 focus:ring-orange-400 sm:text-sm"
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
                                    class="mb-5 h-10 w-full rounded-md border border-orange-400 bg-orange-50 placeholder:text-slate-300 focus:border focus:border-orange-400 focus:ring-orange-600"
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
                                    </div>
                                </transition>
                            </div>

                            <!-- Main table -->
                            <table class="w-full table-auto whitespace-nowrap">
                                <thead>
                                    <tr class="focus:outline-hidden h-12 rounded-lg border border-gray-100 bg-white text-base text-gray-500">
                                        <th class="border-r border-gray-100 pl-5 pr-2 text-left">Medicine</th>
                                        <th class="w-32 border-x border-gray-100 pl-5 text-left">BATCH</th>
                                        <th class="w-32 border-x border-gray-100 pl-5 text-left">Expiry</th>
                                        <th class="w-32 border-x border-gray-100 pl-5 text-left">Qty</th>
                                        <th class="w-32 border-x border-gray-100 pl-5 text-left">Rate</th>
                                        <th class="w-32 border-x border-gray-100 pl-5 text-left">MRP</th>
                                        <th class="W-20 border-x border-gray-100 pl-3 pr-2 text-left">VAT</th>
                                        <th class="w-32 border-x border-gray-100 pl-5 pr-3 text-left">Total</th>
                                        <th class="border-l border-gray-100">ACT</th>
                                    </tr>
                                    <tr class="h-2"></tr>
                                </thead>
                                <tbody class="">
                                    <template v-for="(formRow, index) in form.purchase_items" :key="index">
                                        <tr
                                            class="group h-10 rounded-sm border border-orange-200 bg-orange-50 transition-colors duration-200 ease-in hover:bg-orange-100"
                                        >
                                            <td class="h-10 border-gray-100">
                                                <div class="flex h-full flex-col items-start justify-center bg-slate-100 px-2 capitalize">
                                                    {{ formRow.name }} <br />
                                                    <span class="block truncate text-xs">{{ formRow.strength }}</span>
                                                </div>
                                            </td>
                                            <td class="h-10 w-32 border-gray-100">
                                                <input
                                                    required
                                                    type="text"
                                                    @focus="$event.target.select()"
                                                    @input="formRow.batch_id = $event.target.value.toUpperCase()"
                                                    v-model.trim="formRow.batch_id"
                                                    class="h-full w-full border-0 border-x border-orange-200 bg-orange-50 pr-3 text-right focus:border focus:border-orange-400 focus:ring-orange-600"
                                                />
                                            </td>
                                            <td class="h-10 w-32 border-gray-100">
                                                <input
                                                    required
                                                    type="month"
                                                    v-model="formRow.expiry_date"
                                                    :max="moment().add(5, 'y').format('YYYY-MM-DD')"
                                                    :min="moment().format('YYYY-MM-DD')"
                                                    class="h-full w-full border-0 border-x border-orange-200 bg-orange-50 text-right focus:border focus:border-orange-400 focus:ring-orange-600"
                                                />
                                            </td>
                                            <td class="h-10 w-32 border-gray-100">
                                                <CurrencyInput v-model="formRow.quantity" :disabled="false" />
                                            </td>
                                            <td class="h-10 w-32 border-gray-100">
                                                <CurrencyInput v-model="formRow.purchase_price" :disabled="true" :step="0.01" />
                                            </td>
                                            <td class="h-10 w-32 border-gray-100">
                                                <CurrencyInput v-model="formRow.selling_price" :disabled="false" :step="0.01" />
                                            </td>
                                            <td class="h-10 w-20 border-gray-100">
                                                <CurrencyInput v-model="formRow.vat" :disabled="true" :step="0.01" />
                                            </td>
                                            <td class="h-10 w-32 border-gray-100">
                                                <CurrencyInput v-model="formRow.total_price" :disabled="false" :step="0.01" />
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
                                        <tr class="h-2"></tr>
                                    </template>
                                </tbody>
                                <tfoot>
                                    <tr
                                        class="group h-10 rounded-sm border border-gray-100 bg-gray-50 transition-colors duration-200 ease-in hover:bg-gray-300"
                                    >
                                        <th colspan="7" class="border-x border-gray-100">
                                            <div class="flex items-center justify-end pr-5">Sub Total</div>
                                        </th>
                                        <th colspan="1" class="w-12 border-r border-gray-100">
                                            <CurrencyInput v-model="form.sub_total" :disabled="true" :step="0.01" />
                                        </th>
                                        <th class="w-12 text-xs font-light">BDT</th>
                                    </tr>

                                    <tr
                                        class="group h-10 rounded-sm border border-gray-100 bg-gray-50 transition-colors duration-200 ease-in hover:bg-gray-300"
                                    >
                                        <th colspan="7" class="border-x border-gray-100">
                                            <div class="flex items-center justify-end pr-5">VAT</div>
                                        </th>
                                        <th colspan="1" class="w-12 border-r border-gray-100">
                                            <CurrencyInput v-model="form.vat" :disabled="false" :step="0.01" />
                                        </th>
                                        <th class="w-12 text-xs font-light">%</th>
                                    </tr>
                                    <tr
                                        class="group h-10 rounded-sm border border-gray-100 bg-gray-50 transition-colors duration-200 ease-in hover:bg-gray-300"
                                    >
                                        <th colspan="7" class="border-x border-gray-100">
                                            <div class="flex items-center justify-end pr-5">VAT Total</div>
                                        </th>
                                        <th colspan="1" class="w-12 border-r border-gray-100">
                                            <CurrencyInput v-model="form.vat_total" :disabled="true" :step="0.01" />
                                        </th>
                                        <th class="w-12 text-xs font-light">BDT</th>
                                    </tr>
                                    <tr
                                        class="group h-10 rounded-sm border border-gray-100 bg-gray-50 transition-colors duration-200 ease-in hover:bg-gray-300"
                                    >
                                        <th colspan="7" class="border-x border-gray-100">
                                            <div class="flex items-center justify-end pr-5">Invoice Discount</div>
                                        </th>
                                        <th colspan="1" class="w-12 border-r border-gray-100">
                                            <CurrencyInput v-model="form.discount" :disabled="false" :step="Number(0.01)" />
                                        </th>
                                        <th class="w-12 text-xs font-light">BDT</th>
                                    </tr>
                                    <tr
                                        class="group h-10 rounded-sm border border-gray-100 bg-gray-50 transition-colors duration-200 ease-in hover:bg-gray-300"
                                    >
                                        <th colspan="7" class="border-x border-gray-100">
                                            <div class="flex items-center justify-end pr-5">Grand Total</div>
                                        </th>
                                        <th colspan="1" class="w-12 border-r border-gray-100">
                                            <CurrencyInput v-model="form.grand_total" :disabled="true" :step="0.01" />
                                        </th>
                                        <th class="w-12 text-xs font-light">BDT</th>
                                    </tr>
                                    <tr
                                        class="group h-10 rounded-sm border border-gray-100 bg-gray-50 transition-colors duration-200 ease-in hover:bg-gray-300"
                                    >
                                        <th colspan="7" class="border-x border-gray-100">
                                            <div class="flex items-center justify-end pr-5">Paid Amount</div>
                                        </th>
                                        <th colspan="1" class="w-12 border-r border-gray-100">
                                            <CurrencyInput v-model="form.paid_amount" :disabled="false" :step="0.01" />
                                        </th>
                                        <th class="w-12 text-xs font-light">BDT</th>
                                    </tr>
                                    <tr
                                        class="group h-10 rounded-sm border border-gray-100 bg-gray-50 transition-colors duration-200 ease-in hover:bg-gray-300"
                                    >
                                        <th colspan="7" class="border-x border-gray-100">
                                            <div class="flex items-center justify-end pr-5">Due Amount</div>
                                        </th>
                                        <th colspan="1" class="w-12 border-r border-gray-100">
                                            <CurrencyInput v-model="form.due_amount" :disabled="true" :step="0.01" />
                                        </th>
                                        <th class="w-12 text-xs font-light">BDT</th>
                                    </tr>
                                </tfoot>
                            </table>

                            <!-- Form actions -->
                            <div class="mt-5 flex flex-row-reverse items-center justify-start gap-x-5">
                                <button
                                    type="submit"
                                    class="rounded-md bg-orange-500 px-8 py-2 text-white disabled:bg-slate-400"
                                    :disabled="form.processing"
                                >
                                    Save
                                </button>
                                <button
                                    type="button"
                                    @click="saveItem"
                                    :disabled="form.processing"
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
import AppLayout from '@/layouts/AppLayout.vue';
import Icon from '@/Shared/Icon.vue';
import CurrencyInput from '@/Units/CurrencyInput.vue';
import { Head, useForm } from '@inertiajs/vue3';
import axios from 'axios';
import debounce from 'lodash/debounce';
import moment from 'moment';
import { computed, ref, watch } from 'vue';
import vSelect from 'vue-select';
import 'vue-select/dist/vue-select.css';

const props = defineProps({
    invoice_no: String,
    manufacturers: Object,
});
const form = useForm({
    invoice_no: props.invoice_no,
    purchase_date: moment().format('YYYY-MM-DD'),
    manufacturer_id: null,
    sub_total: 0,
    vat: 17.4,
    discount: 0,
    vat_total: 0,
    grand_total: 0,
    paid_amount: 0,
    due_amount: 0,
    purchase_items: [],
});

// Purchase date
const display_date = computed({
    get() {
        if (moment(form.purchase_date).isValid()) {
            return moment(form.purchase_date).format('LL');
        } else {
            return moment().format('LL');
        }
    },
});

// Manufacturers
const manufacturer = ref({
    id: 1,
    name: 'Select a Manufacturer',
    location: 'Manufacturer Address',
});

const changeManufacturer = (id) => {
    const detail = props.manufacturers.find((item) => item.id === id);
    if (detail) {
        manufacturer.value = detail;
    }
};

watch(
    () => form.manufacturer_id,
    (manufacturer_id) => changeManufacturer(manufacturer_id),
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
                .get(route('purchases.medicine'), {
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
    item.vat = 0;
    item.purchase_price = 0;
    item.batch_id = '';
    item.expiry_date = moment().add(2, 'y').format('YYYY-MM-DD');
    form.purchase_items.push(item);
});

// Calculate fields
watch(
    () => form.purchase_items,
    (items) => {
        items.map((item) => {
            const vat = +Number((parseFloat(item.total_price) / 100) * form.vat).toFixed(2);
            const rate = +Number((parseFloat(item.total_price) + vat) / item.quantity).toFixed(2);

            item.vat = vat;
            item.purchase_price = rate ? rate : 0;
        });
    },
    { deep: true },
);

// Sub total
watch(
    () => form.purchase_items,
    (items) => {
        if (items.length > 0) {
            form.sub_total = +Number(
                items.reduce((accumulator, current) => {
                    return accumulator + parseFloat(current.total_price);
                }, 0),
            ).toFixed(2);
        } else {
            form.sub_total = 0;
        }
    },
    { deep: true },
);

// Purchase date
watch(
    [() => form.sub_total, () => form.discount, () => form.vat_total, () => form.purchase_items],
    () => {
        if (form.purchase_items.length == 0) {
            form.grand_total = 0;
        } else if (!isNaN(form.discount) && form.discount > 0) {
            form.grand_total = +Number(Math.round(form.sub_total - form.discount + form.vat_total)).toFixed(2);
        } else {
            form.grand_total = +Number(Math.round(form.sub_total + form.vat_total)).toFixed(2);
        }
    },
    { deep: true },
);

watch(
    [() => form.purchase_items, () => form.vat],
    () => {
        if (form.purchase_items.length == 0 || form.vat == 0) {
            form.vat_total = 0;
        } else {
            form.vat_total = +Number(form.purchase_items.reduce((accumulator, current) => accumulator + parseFloat(current.vat), 0).toFixed(2));
        }
    },
    { deep: true },
);

watch(
    [() => form.grand_total, () => form.paid_amount],
    () => {
        if (!isNaN(form.paid_amount) && form.paid_amount > 0) {
            form.due_amount = +Number(form.grand_total - form.paid_amount).toFixed(2);
        } else {
            form.due_amount = +form.grand_total;
        }
    },
    { immediate: true },
);

const removeItem = (index) => {
    form.purchase_items.splice(index, 1);
};

// Form Actions
const saveItem = async () => {
    if (!form.processing) {
        try {
            await form.post(route('purchases.store'), {
                preserveScroll: true,
            });
        } catch (error) {
            console.error('Error saving purchase:', error);
        }
    }
};
</script>
