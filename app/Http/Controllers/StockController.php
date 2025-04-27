<?php

namespace App\Http\Controllers;

use App\Models\Stock;
use Carbon\Carbon;
use Illuminate\Support\Facades\Request;
use Inertia\Inertia;

class StockController extends Controller
{
    public function index()
    {

        return Inertia::render('Stocks/Index', [
            'filters' => Request::only('search'),
            'stocks' => Stock::with('medicine:id,name,manufacturer_id', 'medicine.manufacturer:id,name')
                ->orderBy('updated_at', 'desc')
                ->filter(Request::only('search'))
                ->paginate(10)
                ->withQueryString()
                ->through(fn ($stock) => [
                    'id' => $stock->id,
                    'medicine' => $stock->medicine->name,
                    'manufacturer' => $stock->medicine->manufacturer->name,
                    'batch_id' => $stock->batch_id,
                    'stock' => $stock->stock,
                    'expiry_date' => Carbon::parse($stock->expiry_date)->format('d/m/Y'),
                    'created_at' => Carbon::parse($stock->created_at)->format('M d, Y'),
                    'updated_at' => Carbon::parse($stock->updated_at)->format('M d, Y'),
                ]),
        ]);
    }

    public function show()
    {
        // code...
    }
    public function create()
{
    $latest_invoice = \App\Models\Sale::withTrashed()->latest()->max('id') + 1;
    $invoice_no = 'SL-'.str_pad((int) $latest_invoice, 6, '0', STR_PAD_LEFT);

    return Inertia::render('Stocks/Create', [
        'invoice_no' => $invoice_no,
        'medicines' => \App\Models\Medicine::select(['id', 'name', 'manufacturer_id'])
            ->with('manufacturer:id,name')
            ->orderBy('name')
            ->get()
            ->map(function ($medicine) {
                return [
                    'value' => $medicine->id,
                    'label' => $medicine->name . ' (' . $medicine->manufacturer->name . ')'
                ];
            }),
        'initialValues' => [
            'medicine_id' => null,
            'batch_id' => '',
            'quantity' => 1,
            'expiry_date' => now()->addYear()->format('Y-m-d'),
            'purchase_price' => 0,
            'selling_price' => 0,
            'invoice_no' => $invoice_no,
            'supplier' => '',
            'remarks' => ''
        ]
    ]);
}
}
