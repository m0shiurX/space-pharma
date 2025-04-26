<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Inertia\Inertia;
use App\Models\Medicine;
use App\Models\Purchase;
use App\Models\Manufacturer;
use App\Models\PurchaseItem;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Request;
use App\Http\Requests\StorePurchaseRequest;
use App\Http\Requests\UpdatePurchaseRequest;
use App\Http\Resources\PurchaseItemResource;

class PurchaseController extends Controller
{
    public function index()
    {
        return Inertia::render('Purchases/Index', [
            'filters' => Request::only('search'),
            'purchases' => Purchase::with('manufacturer:id,name')
                ->orderBy('created_at', 'desc')
                ->filter(Request::only('search'))
                ->paginate(10)
                ->withQueryString()
                ->through(fn ($purchase) => [
                    'id' => $purchase->id,
                    'invoice_no' => $purchase->invoice_no,
                    'purchase_date' => Carbon::parse($purchase->purchase_date)->format('M d, Y'),
                    'manufacturer' => $purchase->manufacturer->name,
                    'sub_total' => $purchase->sub_total,
                    'vat' => $purchase->vat,
                    'vat_total' => $purchase->vat_total,
                    'discount' => $purchase->discount,
                    'grand_total' => $purchase->grand_total,
                    'paid_amount' => $purchase->paid_amount,
                    'due_amount' => $purchase->due_amount,
                    'created_at' => Carbon::parse($purchase->created_at)->format('M d, Y'),
                    'updated_at' => Carbon::parse($purchase->updated_at)->format('M d, Y'),
                ])
        ]);
    }

    public function create()
    {
        $latest_invoice = \App\Models\Purchase::withTrashed()->latest()->max('id') + 1;
        $invoice_no = 'PR-' . str_pad((int)$latest_invoice, 6, '0', STR_PAD_LEFT);

        return Inertia::render('Purchases/Create', [
            'filters' => Request::only('search'),
            'invoice_no' => $invoice_no,
            'manufacturers' => Manufacturer::select(['id', 'name', 'location'])
                ->orderBy('name', 'asc')
                ->get()
                ->map(fn ($manufacturer) => [
                    'id' => $manufacturer->id,
                    'name' => $manufacturer->name,
                    'location' => $manufacturer->location
                ]),
        ]);
    }

    public function store(StorePurchaseRequest $request)
    {
        DB::transaction(function () use ($request): void {
            $purchase = Purchase::create($request->only([
                'invoice_no',
                'purchase_date',
                'manufacturer_id',
                'sub_total',
                'vat',
                'vat_total',
                'discount',
                'grand_total',
                'paid_amount',
                'due_amount'
            ]));


            foreach ($request->purchase_items as $purchase_item) {
                $entry = [];
                $entry['purchase_id'] = $purchase->id;
                $entry['medicine_id'] = $purchase_item['id'];
                $entry['batch_id'] = $purchase_item['batch_id'];
                $entry['expiry_date'] = $purchase_item['expiry_date'];
                $entry['quantity'] = $purchase_item['quantity'];
                $entry['vat'] = $purchase_item['vat'];
                $entry['purchase_price'] = $purchase_item['purchase_price'];
                $entry['selling_price'] = $purchase_item['selling_price'];
                $entry['total_price'] = $purchase_item['total_price'];

                PurchaseItem::create($entry);
            }
        });

        return redirect()->route('purchases.index')->with('success', 'Successfully created!');
    }

    public function show(Purchase $purchase)
    {
        $purchase->load('purchaseItems', 'manufacturer', 'purchaseItems.medicine');

        return Inertia::render('Purchases/Show', [
            'purchase' => [
                'id' => $purchase->id,
                'invoice_no' => $purchase->invoice_no,
                'manufacturer' => $purchase->manufacturer->name,
                'sub_total' => $purchase->sub_total,
                'invoice_discount' => $purchase->discount,
                'grand_total' => $purchase->grand_total,
                'vat' => $purchase->vat,
                'vat_total' => $purchase->vat_total,
                'paid_amount' => $purchase->paid_amount,
                'due_amount' => $purchase->due_amount,
                'purchase_date' => Carbon::parse($purchase->purchase_date)->format('d M, Y'),
                'purchase_items' => PurchaseItemResource::collection($purchase->purchaseItems)
            ]
        ]);
    }

    public function edit(Purchase $purchase)
    {
        //
    }

    public function update(UpdatePurchaseRequest $request, Purchase $purchase)
    {
        //
    }

    public function destroy(Purchase $purchase)
    {
        //
    }

    public function searchMedicine(\Illuminate\Http\Request $request)
    {
        return Medicine::query()
            ->orderBy('created_at', 'desc')
            ->filter(['search' => $request->input('query')])
            ->limit(20)
            ->get()
            ->map(fn ($medicine) => [
                'id' => $medicine->id,
                'name' => $medicine->name,
                'strength' => $medicine->strength,
                'purchase_price' => $medicine->purchase_price,
                'selling_price' => $medicine->selling_price,
            ]);
    }
}
