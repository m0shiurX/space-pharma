<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Stock;
use Carbon\Carbon;
use Illuminate\Support\Facades\Request;

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
                ])
        ]);
    }

    public function show()
    {
        # code...
    }
}
