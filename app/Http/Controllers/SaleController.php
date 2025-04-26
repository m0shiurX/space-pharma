<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Sale;
use Inertia\Inertia;
use App\Models\Customer;
use App\Models\Medicine;
use App\Models\SalesItem;
use Illuminate\Support\Facades\DB;
use App\Http\Resources\StockResource;
use App\Http\Requests\StoreSaleRequest;
use Illuminate\Support\Facades\Request;
use App\Http\Requests\UpdateSaleRequest;
use App\Notifications\SalesNotification;
use App\Http\Resources\SalesItemResource;

class SaleController extends Controller
{

    public function index()
    {
        return Inertia::render('Sales/Index', [
            'filters' => Request::only('search'),
            'sales' => Sale::with('customer:id,name')
                ->orderBy('created_at', 'desc')
                ->filter(Request::only('search'))
                ->paginate(10)
                ->withQueryString()
                ->through(fn ($sale) => [
                    'id' => $sale->id,
                    'invoice_no' => $sale->invoice_no,
                    'sales_date' => Carbon::parse($sale->sales_date)->format('M d, Y'),
                    'customer' => $sale->customer->name,
                    'sub_total' => $sale->sub_total,
                    'vat' => $sale->vat,
                    'invoice_discount' => $sale->invoice_discount,
                    'grand_total' => $sale->grand_total,
                    'paid_amount' => $sale->paid_amount,
                    'exchange_amount' => $sale->exchange_amount,
                    'created_at' => Carbon::parse($sale->created_at)->format('M d, Y'),
                    'updated_at' => Carbon::parse($sale->updated_at)->format('M d, Y'),
                ])
        ]);
    }


    public function create()
    {
        $latest_invoice = \App\Models\Sale::withTrashed()->latest()->max('id') + 1;
        $invoice_no = 'SL-' . str_pad((int)$latest_invoice, 6, '0', STR_PAD_LEFT);

        return Inertia::render('Sales/Create', [
            'filters' => Request::only('search'),
            'invoice_no' => $invoice_no,
            'customers' => Customer::select(['id', 'name', 'phone'])
                ->orderBy('name', 'asc')
                ->get()
                ->map(fn ($customer) => [
                    'id' => $customer->id,
                    'name' => $customer->name,
                    'phone' => $customer->phone
                ]),
        ]);
    }


    public function store(StoreSaleRequest $request)
    {
        // return dd($request->all());

        DB::transaction(function () use ($request): void {
            $sale = Sale::create($request->only([
                'customer_id',
                'invoice_no',
                'sales_date',
                'sub_total',
                'invoice_discount',
                'vat',
                'grand_total',
                'paid_amount',
                'exchange_amount',
            ]));


            foreach ($request->sales_items as $sales_item) {
                $entry = [];
                $entry['sale_id'] = $sale->id;
                $entry['medicine_id'] = $sales_item['id'];
                $entry['batch_id'] = $sales_item['batch_id'];
                $entry['quantity'] = $sales_item['quantity'];
                $entry['selling_price'] = $sales_item['selling_price'];
                $entry['discount'] = $sales_item['discount'];
                $entry['total_price'] = $sales_item['total_price'];

                SalesItem::create($entry);
            }
        });

        $customer = Customer::find($request->only('customer_id'))->first();
        if ($customer->phone != 0) {
            $customer->notify(new SalesNotification());
        }

        return redirect()->route('sales.index')->with('success', 'Successfully created and sent sms!');
    }


    public function show(Sale $sale)
    {
        $sale->load('salesItems', 'customer', 'salesItems.medicine');

        return Inertia::render('Sales/Show', [
            'sale' => [
                'id' => $sale->id,
                'invoice_no' => $sale->invoice_no,
                'sales_date' => Carbon::parse($sale->sales_date)->format('d M, Y'),
                'customer_name' => $sale->customer->name,
                'customer_phone' => $sale->customer->phone,
                'customer_address' => $sale->customer->address,
                'sub_total' => $sale->sub_total,
                'invoice_discount' => $sale->invoice_discount,
                'vat' => $sale->vat,
                'grand_total' => $sale->grand_total,
                'paid_amount' => $sale->paid_amount,
                'exchange_amount' => $sale->exchange_amount,
                'sales_items' => SalesItemResource::collection($sale->salesItems)
            ]
        ]);
    }


    public function edit(Sale $sale)
    {
        //
    }


    public function update(UpdateSaleRequest $request, Sale $sale)
    {
        //
    }


    public function destroy(Sale $sale)
    {
        //
    }

    public function searchMedicine(\Illuminate\Http\Request $request)
    {
        return Medicine::with('stocks')
            ->orderBy('created_at', 'desc')
            ->filter(['search' => $request->input('query')])
            ->limit(20)
            ->get()
            ->map(fn ($medicine) => [
                'id' => $medicine->id,
                'name' => $medicine->name,
                'strength' => $medicine->strength,
                'selling_price' => $medicine->selling_price,
                'discount' => $medicine->discount,
                'stocks' => StockResource::collection($medicine->stocks)
            ]);
    }
}
