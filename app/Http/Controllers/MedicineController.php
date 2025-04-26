<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Inertia\Inertia;
use App\Models\Medicine;
use App\Models\Manufacturer;
use App\Exports\MedicinesExport;
use App\Imports\MedicinesImport;
use Illuminate\Support\Facades\Bus;
use App\Imports\ManufacturersImport;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Resources\StockResource;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests\StoreMedicineRequest;
use App\Http\Requests\UpdateMedicineRequest;

class MedicineController extends Controller
{
    public function index()
    {
        return Inertia::render('Medicines/Index', [
            'filters' => Request::only('search'),
            'medicines' => Medicine::with('manufacturer:id,name')
                ->withSum('stocks', 'stock')
                ->orderBy('stocks_sum_stock', 'desc')
                ->filter(Request::only('search'))
                ->paginate(10)
                ->withQueryString()
                ->through(fn ($medicine) => [
                    'id' => $medicine->id,
                    'name' => $medicine->name,
                    'generic_name' => $medicine->generic_name,
                    'manufacturer' => $medicine->manufacturer->name,
                    'strength' => $medicine->strength,
                    'category' => $medicine->category,
                    'unit' => $medicine->unit,
                    'purchase_price' => $medicine->purchase_price,
                    'selling_price' => $medicine->selling_price,
                    'discount' => $medicine->discount,
                    'in_stock'  => $medicine->stocks_sum_stock,
                    'created_at' => Carbon::parse($medicine->created_at)->format('M d, Y'),
                    'updated_at' => Carbon::parse($medicine->updated_at)->format('M d, Y'),
                ])
        ]);
    }

    public function create()
    {
        return Inertia::render('Medicines/Create', [
            'manufacturers' => Manufacturer::select('id', 'name')->get()
        ]);
    }

    public function store(StoreMedicineRequest $request)
    {
        Medicine::create($request->validated());
        return Redirect::route('medicines.index')->with('success', 'Medicine created.');
    }

    public function show(Medicine $medicine)
    {
        return Inertia::render('Medicines/Show', [
            'medicine' => [
                'id' => $medicine->id,
                'name' => $medicine->name,
                'generic_name' => $medicine->generic_name,
                'manufacturer' => $medicine->manufacturer->name,
                'strength' => $medicine->strength,
                'category' => $medicine->category,
                'unit' => $medicine->unit,
                'purchase_price' => $medicine->purchase_price,
                'selling_price' => $medicine->selling_price,
                'discount' => $medicine->discount,
                'stocks' => StockResource::collection($medicine->stocks),
            ]
        ]);
    }

    public function edit(Medicine $medicine)
    {
        $medicine->load('manufacturer');
        return Inertia::render('Medicines/Edit', [
            'manufacturers' => Manufacturer::select('id', 'name')->get(),
            'medicine' => [
                'id' => $medicine->id,
                'name' => $medicine->name,
                'generic_name' => $medicine->generic_name,
                'manufacturer_id' => $medicine->manufacturer->name,
                'strength' => $medicine->strength,
                'category' => $medicine->category,
                'unit' => $medicine->unit,
                'purchase_price' => $medicine->purchase_price,
                'selling_price' => $medicine->selling_price,
                'discount' => $medicine->discount,
            ]
        ]);
    }

    public function update(UpdateMedicineRequest $request, Medicine $medicine)
    {
        $medicine->update($request->validated());
        return Redirect::route('medicines.index')->with('success', 'Successfully updated.');
    }

    public function destroy(Medicine $medicine)
    {
        $medicine->delete();
        return Redirect::route('medicines.index')->with('success', 'Successfully deleted.');
    }

    public function importMedicines(\Illuminate\Http\Request $request)
    {
        $file_path = $request->file('file')->store('storage');
        Bus::chain([Excel::import(new MedicinesImport, $file_path)]);
        return redirect()->route('medicines.index')->with('success', 'Successfully started importing!');
    }

    public function exportMedicines()
    {
        return Excel::download(new MedicinesExport, 'medicines.csv');
    }
}
