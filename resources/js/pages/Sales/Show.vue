<template>
    <Head title="Manufacturers" />

    <AppLayout>
        <template #header>
            <h2 class="text-xl font-semibold capitalize leading-tight text-gray-800">{{ sale.invoice_no }}</h2>
        </template>

        <div class="mt-8 rounded-lg bg-white/30 py-8">
            <div class="rounded-lg px-4 md:px-8 xl:px-10">
                <div class="w-lg printer_width mx-auto max-w-2xl" ref="printDiv">
                    <div class="printer_content text-xs">
                        <!-- Shop Info -->
                        <div class="printer_header text-center">
                            <h1 class="text-sm font-bold">Akota Pharma</h1>
                            <p>Dada Vai Bhaban, Uposhohor</p>
                            <p>Bogura - 5800</p>
                            <p class="font-semibold">+880 1711 111 222</p>
                        </div>

                        <!-- Invoice Info -->
                        <div class="printer_invoice_info mx-2 flex justify-between">
                            <div><span class="font-bold">Invoice no: </span> # {{ sale.invoice_no }}</div>
                            <div><span class="font-bold">Date: </span> # {{ sale.sales_date }}</div>
                        </div>

                        <!-- Customer Info -->
                        <div class="printer_customer_info mx-2 mt-3">
                            <div><span class="font-bold"> Name:</span> {{ sale.customer_name }}</div>
                            <div><span class="font-bold"> Phone:</span> {{ sale.customer_phone }}</div>
                            <div><span class="font-bold"> Address:</span> {{ sale.customer_address }}</div>
                        </div>

                        <!-- Invoice Table -->
                        <div class="printer_table_container mt-3">
                            <table class="printer_table w-full table-fixed bg-slate-200">
                                <thead>
                                    <tr class="h-10 border border-gray-100 bg-gray-50">
                                        <th class="border-x border-gray-100">SL</th>
                                        <th class="border-x border-gray-100 pl-5 text-left">Item</th>
                                        <th class="border-x border-gray-100">Qty</th>
                                        <th class="border-x border-gray-100">Rate</th>
                                        <th class="border-x border-gray-100">Amount</th>
                                    </tr>
                                    <tr class="h-1"></tr>
                                </thead>

                                <tbody>
                                    <template v-for="(item, index) in sale.sales_items.data" :key="index">
                                        <tr class="h-10 border border-gray-100 bg-gray-50 text-center">
                                            <td class="border-x border-gray-100">{{ index + 1 }}</td>
                                            <td class="border-r border-gray-100 pl-5 text-left">
                                                {{ item.medicine_name }}
                                                <span class="block text-xs"> {{ item.batch_id }}</span>
                                            </td>
                                            <td class="border-r border-gray-100">{{ item.quantity }}</td>
                                            <td class="border-r border-gray-100">{{ item.selling_price }}</td>
                                            <td class="border-r border-gray-100">{{ item.total_price }}</td>
                                        </tr>
                                        <tr class="h-1"></tr>
                                    </template>
                                </tbody>
                                <tfoot>
                                    <tr class="h-10 border border-gray-100 bg-gray-50">
                                        <th colspan="4" class="border-x border-gray-100">
                                            <div class="flex items-center justify-end pr-5">Sub Total</div>
                                        </th>
                                        <th colspan="1" class="border-r border-gray-100">
                                            {{ sale.sub_total }}
                                        </th>
                                    </tr>
                                    <tr class="h-10 border border-gray-100 bg-gray-50">
                                        <th colspan="4" class="border-x border-gray-100">
                                            <div class="flex items-center justify-end pr-5">Invoice Discount</div>
                                        </th>
                                        <th colspan="1" class="border-r border-gray-100">
                                            {{ sale.invoice_discount }}
                                        </th>
                                    </tr>
                                    <tr class="h-10 border border-gray-100 bg-gray-50">
                                        <th colspan="4" class="border-x border-gray-100">
                                            <div class="flex items-center justify-end pr-5">Grand Total</div>
                                        </th>
                                        <th colspan="1" class="border-r border-gray-100">
                                            {{ sale.grand_total }}
                                        </th>
                                    </tr>
                                    <tr class="h-10 border border-gray-100 bg-gray-50">
                                        <th colspan="4" class="border-x border-gray-100">
                                            <div class="flex items-center justify-end pr-5">Paid Total</div>
                                        </th>
                                        <th colspan="1" class="border-r border-gray-100">
                                            {{ sale.paid_amount }}
                                        </th>
                                    </tr>
                                    <tr class="h-10 border border-gray-100 bg-gray-50">
                                        <th colspan="4" class="border-x border-gray-100">
                                            <div class="flex items-center justify-end pr-5">Exchange Total</div>
                                        </th>
                                        <th colspan="1" class="border-r border-gray-100">
                                            {{ sale.exchange_amount }}
                                        </th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>

                        <!-- Credits -->
                        <div class="printer_credits"></div>
                    </div>
                    <div class="printer_buttons mt-6 print:hidden">
                        <div class="flex items-center justify-end space-x-5">
                            <Link :href="route('sales.index')" as="button" tabindex="0" class="rounded-md bg-green-500 px-8 py-2 text-white">
                                Back
                            </Link>
                            <button type="button" @click="printItem" class="rounded-md bg-orange-500 px-8 py-2 text-white">Print</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
<script setup>
import { Head, Link } from '@inertiajs/vue3';

import AppLayout from '@/layouts/AppLayout.vue';
import { Printd } from 'printd';
import { ref } from 'vue';

defineProps({
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
    printer.print(printDiv.value, cssText);
    window.print();
    console.log('trying to print the invoice', printDiv.value);
};
</script>

<style scoped></style>
