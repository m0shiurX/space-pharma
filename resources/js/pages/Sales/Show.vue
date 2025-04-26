<template>

    <Head title="Manufacturers" />

    <AuthLayout>
        <template #header>
            <h2 class="font-semibold text-gray-800 text-xl capitalize leading-tight">{{ sale.invoice_no }}</h2>
        </template>

        <div class="bg-white/30 mt-8 py-8 rounded-lg">
            <div class="px-4 md:px-8 xl:px-10 rounded-lg">
                <div class="mx-auto w-lg max-w-2xl printer_width" ref="printDiv">
                    <div class="text-xs printer_content">
                        <!-- Shop Info -->
                        <div class="text-center printer_header">
                            <h1 class="font-bold text-sm">Akota Pharma</h1>
                            <p>Dada Vai Bhaban, Uposhohor</p>
                            <p>Bogura - 5800</p>
                            <p class="font-semibold">+880 1711 111 222</p>
                        </div>

                        <!-- Invoice Info -->
                        <div class="flex justify-between mx-2 printer_invoice_info">
                            <div><span class="font-bold">Invoice no: </span> # {{ sale.invoice_no }}</div>
                            <div><span class="font-bold">Date: </span> # {{ sale.sales_date }}</div>
                        </div>

                        <!-- Customer Info -->
                        <div class="mx-2 mt-3 printer_customer_info">
                            <div><span class="font-bold"> Name:</span> {{ sale.customer_name }}</div>
                            <div><span class="font-bold"> Phone:</span> {{ sale.customer_phone }}</div>
                            <div><span class="font-bold"> Address:</span> {{ sale.customer_address }}</div>
                        </div>

                        <!-- Invoice Table -->
                        <div class="mt-3 printer_table_container">
                            <table class="table-fixed bg-slate-200 w-full printer_table">
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
                                    <template v-for="(item, index) in sale.sales_items.data" :key="index">
                                        <tr class="bg-gray-50 border border-gray-100 h-10 text-center">
                                            <td class="border-gray-100 border-x">{{ index + 1 }}</td>
                                            <td class="pl-5 border-gray-100 border-r text-left">
                                                {{ item.medicine_name }}
                                                <span class="block text-xs"> {{ item.batch_id }}</span>
                                            </td>
                                            <td class="border-gray-100 border-r">{{ item.quantity }}</td>
                                            <td class="border-gray-100 border-r">{{ item.selling_price }}</td>
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
                                            {{ sale.sub_total }}
                                        </th>
                                    </tr>
                                    <tr class="bg-gray-50 border border-gray-100 h-10">
                                        <th colspan="4" class="border-gray-100 border-x">
                                            <div class="flex justify-end items-center pr-5">Invoice Discount</div>
                                        </th>
                                        <th colspan="1" class="border-gray-100 border-r">
                                            {{ sale.invoice_discount }}
                                        </th>
                                    </tr>
                                    <!-- <tr class="bg-gray-50 border border-gray-100 h-10">
                                        <th colspan="4" class="border-gray-100 border-x">
                                            <div class="flex justify-end items-center pr-5">VAT</div>
                                        </th>
                                        <th colspan="1" class="border-gray-100 border-r">
                                            {{ sale.vat }}
                                        </th>
                                    </tr> -->
                                    <tr class="bg-gray-50 border border-gray-100 h-10">
                                        <th colspan="4" class="border-gray-100 border-x">
                                            <div class="flex justify-end items-center pr-5">Grand Total</div>
                                        </th>
                                        <th colspan="1" class="border-gray-100 border-r">
                                            {{ sale.grand_total }}
                                        </th>
                                    </tr>
                                    <tr class="bg-gray-50 border border-gray-100 h-10">
                                        <th colspan="4" class="border-gray-100 border-x">
                                            <div class="flex justify-end items-center pr-5">Paid Total</div>
                                        </th>
                                        <th colspan="1" class="border-gray-100 border-r">
                                            {{ sale.paid_amount }}
                                        </th>
                                    </tr>
                                    <tr class="bg-gray-50 border border-gray-100 h-10">
                                        <th colspan="4" class="border-gray-100 border-x">
                                            <div class="flex justify-end items-center pr-5">Exchange Total</div>
                                        </th>
                                        <th colspan="1" class="border-gray-100 border-r">
                                            {{ sale.exchange_amount }}
                                        </th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>

                        <!-- Credits -->
                        <div class="printer_credits"></div>
                    </div>
                    <div class="print:hidden mt-6 printer_buttons">
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
    sale: Object,
});

// const destroyItem = () => {
//     if (confirm('Are you sure you want to delete?')) {
//         Inertia.delete(route('sales.destroy', props.sale.id));
//     }
// };
const printDiv = ref(null);
const printer = new Printd();

const cssText = `
.printer_width {
    widows: 72mm;
    max-width: 80mm;
    overflow: hidden;
    margin: 0 auto;
}
.printer_content {
    width: 100%;
}
.printer_invoice_info {
    text-align: center;
    width: 100%;
}
.printer_customer_info {
    text-align: left;
    margin-left: 8px;
}
.printer_table_container {
    width: 100%;
}

.printer_table {
    width: 100%;
    border-collapse: collapse;
}
.printer_credits {
    widows: 100%;
    margin: 20px 0;
}`;

const printItem = () => {
    // printer.print(printDiv.value, cssText);
    window.print();
    console.log('trying to print the invoice', printDiv.value);
};
</script>

<style scoped></style>
