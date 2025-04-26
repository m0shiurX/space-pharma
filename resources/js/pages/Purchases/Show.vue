<template>

    <Head title="Purchases" />

    <AuthLayout>
        <template #header>
            <h2 class="font-semibold text-gray-800 text-xl capitalize leading-tight">{{ purchase.invoice_no }}</h2>
        </template>

        <div class="bg-white/30 mt-8 py-8 rounded-lg">
            <div class="px-4 md:px-8 xl:px-10 rounded-lg">
                <div class="mx-auto w-lg max-w-lg" ref="printDiv">
                    <div class="text-xs">
                        <!-- Shop Info -->
                        <div class="text-center">
                            <h1 class="font-bold text-sm">Akota Pharma</h1>
                            <p>Dada Vai Bhaban, Uposhohor</p>
                            <p>Bogura - 5800</p>
                            <p class="font-semibold">+880 1711 111 222</p>
                        </div>

                        <!-- Invoice Info -->
                        <div class="flex justify-between mx-2">
                            <div><span class="font-bold">Invoice no: </span> # {{ purchase.invoice_no }}</div>
                            <div><span class="font-bold">Date: </span> # {{ purchase.purchase_date }}</div>
                        </div>

                        <!-- Customer Info -->
                        <div class="mx-2 mt-3">
                            <div><span class="font-bold"> Name:</span> {{ purchase.manufacturer }}</div>
                        </div>

                        <!-- Invoice Table -->
                        <div class="mt-3">
                            <table class="table-fixed bg-slate-200 w-full">
                                <thead>
                                    <tr class="bg-gray-50 border border-gray-100 h-10">
                                        <th class="border-gray-100 border-x">SL</th>
                                        <th class="pl-5 border-gray-100 border-x text-left">Item</th>
                                        <th class="border-gray-100 border-x">Qty</th>
                                        <th class="border-gray-100 border-x">Rate</th>
                                        <th class="border-gray-100 border-x">Amount</th>
                                    </tr>
                                    <tr class="h-1"></tr>
                                </thead>

                                <tbody>
                                    <template v-for="(item, index) in purchase.purchase_items.data" :key="index">
                                        <tr class="bg-gray-50 border border-gray-100 h-10 text-center">
                                            <td class="border-gray-100 border-x">{{ index + 1 }}</td>
                                            <td class="pl-5 border-gray-100 border-r text-left">
                                                {{ item.medicine_name }}
                                                <span class="block text-xs"> {{ item.batch_id }}</span>
                                            </td>
                                            <td class="border-gray-100 border-r">{{ item.quantity }}</td>
                                            <td class="border-gray-100 border-r">{{ item.purchase_price }}</td>
                                            <td class="border-gray-100 border-r">{{ item.total_price }}</td>
                                        </tr>
                                        <tr class="h-1"></tr>
                                    </template>
                                </tbody>
                                <tfoot>
                                    <tr class="bg-gray-50 border border-gray-100 h-10">
                                        <th colspan="4" class="border-gray-100 border-x">
                                            <div class="flex justify-end items-center pr-5">Sub Total</div>
                                        </th>
                                        <th colspan="1" class="border-gray-100 border-r">
                                            {{ purchase.sub_total }}
                                        </th>
                                    </tr>

                                    <tr class="bg-gray-50 border border-gray-100 h-10">
                                        <th colspan="4" class="border-gray-100 border-x">
                                            <div class="flex justify-end items-center pr-5">VAT</div>
                                        </th>
                                        <th colspan="1" class="border-gray-100 border-r">
                                            {{ purchase.vat }}
                                        </th>
                                    </tr>
                                    <tr class="bg-gray-50 border border-gray-100 h-10">
                                        <th colspan="4" class="border-gray-100 border-x">
                                            <div class="flex justify-end items-center pr-5">VAT Total</div>
                                        </th>
                                        <th colspan="1" class="border-gray-100 border-r">
                                            {{ purchase.vat_total }}
                                        </th>
                                    </tr>
                                    <tr class="bg-gray-50 border border-gray-100 h-10">
                                        <th colspan="4" class="border-gray-100 border-x">
                                            <div class="flex justify-end items-center pr-5">Invoice Discount</div>
                                        </th>
                                        <th colspan="1" class="border-gray-100 border-r">
                                            {{ purchase.invoice_discount }}
                                        </th>
                                    </tr>
                                    <tr class="bg-gray-50 border border-gray-100 h-10">
                                        <th colspan="4" class="border-gray-100 border-x">
                                            <div class="flex justify-end items-center pr-5">Grand Total</div>
                                        </th>
                                        <th colspan="1" class="border-gray-100 border-r">
                                            {{ purchase.grand_total }}
                                        </th>
                                    </tr>
                                    <tr class="bg-gray-50 border border-gray-100 h-10">
                                        <th colspan="4" class="border-gray-100 border-x">
                                            <div class="flex justify-end items-center pr-5">Paid Amount</div>
                                        </th>
                                        <th colspan="1" class="border-gray-100 border-r">
                                            {{ purchase.paid_amount }}
                                        </th>
                                    </tr>
                                    <tr class="bg-gray-50 border border-gray-100 h-10">
                                        <th colspan="4" class="border-gray-100 border-x">
                                            <div class="flex justify-end items-center pr-5">Due Amount</div>
                                        </th>
                                        <th colspan="1" class="border-gray-100 border-r">
                                            {{ purchase.due_amount }}
                                        </th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>

                        <!-- Credits -->
                        <div class=""></div>
                    </div>
                    <div class="print:hidden mt-6">
                        <div class="flex justify-end items-center space-x-5">
                            <Link :href="route('sales.index')" as="button" tabindex="0"
                                class="bg-green-500 px-8 py-2 rounded-md text-white">
                            Back
                            </Link>
                            <button type="button" @click="printItem"
                                class="bg-orange-500 px-8 py-2 rounded-md text-white">Print</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthLayout>
</template>
<script setup>
import { Head, Link, useForm } from '@inertiajs/vue3';
import { router } from '@inertiajs/vue3';
import AuthLayout from '@/Layouts/AuthLayout.vue';
import { ref } from 'vue';
import { Printd } from 'printd';

const props = defineProps({
    purchase: Object,
});

const printer = new Printd();

const printDiv = ref(null);
const testPrint = ref(null);

const printItem = () => {
    console.log('trying to print the invoice', printDiv.value);
};
const printTest = () => {
    // printer.print(testPrint.value, cssText);
};
</script>
