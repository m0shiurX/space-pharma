<?php

namespace App\Exports;

use App\Models\Manufacturer;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;

class ManufacturersExport implements FromCollection
{

    public function collection(): collection
    {
        return Manufacturer::query()
            ->select('name', 'location', 'contact_name', 'contact_tel')
            ->get()
            ->map(fn ($manufacturer) => [
                'manufacturer' => $manufacturer->name,
                'location' => $manufacturer->location,
                'contact_name' => $manufacturer->contact_name,
                'contact_tel' => $manufacturer->contact_tel,
            ]);
    }
}
