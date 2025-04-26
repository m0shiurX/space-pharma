<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Inertia\Inertia;
use App\Models\Manufacturer;
use Illuminate\Support\Facades\Bus;
use App\Exports\ManufacturersExport;
use App\Imports\ManufacturersImport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests\StoreManufacturerRequest;
use App\Http\Requests\UpdateManufacturerRequest;


class ManufacturerController extends Controller
{
    public function index()
    {
        return Inertia::render('Manufacturers/Index', [
            'filters' => Request::only('search'),
            'manufacturers' => Manufacturer::orderBy('name', 'asc')
                ->filter(Request::only('search'))
                ->paginate(10)
                ->withQueryString()
                ->through(fn ($manufacturer) => [
                    'id' => $manufacturer->id,
                    'name' => $manufacturer->name,
                    'location' => $manufacturer->location,
                    'contact_name' => $manufacturer->contact_name,
                    'contact_tel' => $manufacturer->contact_tel,
                    'created_at' => Carbon::parse($manufacturer->created_at)->format('M d, Y'),
                ]),
        ]);
    }

    public function create()
    {
        return Inertia::render('Manufacturers/Create');
    }

    public function store(StoreManufacturerRequest $request)
    {
        Manufacturer::create($request->validated());
        return Redirect::route('manufacturers.index')->with('success', 'Manufacturer created.');
    }

    public function show(Manufacturer $manufacturer)
    {
        return Inertia::render('Manufacturers/Show', [
            'manufacturer' => [
                'id' => $manufacturer->id,
                'name' => $manufacturer->name,
                'location' => $manufacturer->location,
                'contact_name' => $manufacturer->contact_name,
                'contact_tel' => $manufacturer->contact_tel,
            ]
        ]);
    }

    public function edit(Manufacturer $manufacturer)
    {
        return Inertia::render('Manufacturers/Edit', [
            'manufacturer' => [
                'id' => $manufacturer->id,
                'name' => $manufacturer->name,
                'location' => $manufacturer->location,
                'contact_name' => $manufacturer->contact_name,
                'contact_tel' => $manufacturer->contact_tel,
            ]
        ]);
    }

    public function update(UpdateManufacturerRequest $request, Manufacturer $manufacturer)
    {
        $manufacturer->update($request->validated());

        return Redirect::route('manufacturers.index')->with('success', 'Successfully updated.');

        // return Redirect::back()->with('success', 'Successfully updated.');
    }

    public function destroy(Manufacturer $manufacturer)
    {
        $manufacturer->delete();

        // return Redirect::back()->with('success', 'Successfully deleted.');
        return Redirect::route('manufacturers.index')->with('success', 'Successfully deleted.');
    }


    public function importManufacturers(\Illuminate\Http\Request $request)
    {
        $file_path = $request->file('file')->store('storage');
        Bus::chain([Excel::import(new ManufacturersImport, $file_path)]);

        return redirect()->route('manufacturers.index')->with('success', 'Successfully started importing!');
    }

    public function exportManufacturers()
    {
        return Excel::download(new ManufacturersExport, 'manufacturers.csv');
    }
}
