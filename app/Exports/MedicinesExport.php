<?php

namespace App\Exports;

ini_set('memory_limit', '-1');

use App\Models\Medicine;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;

class MedicinesExport implements FromCollection
{

    public function collection(): collection
    {
        return Medicine::with('manufacturer')
            ->select('name', 'generic_name', 'manufacturer_id', 'strength', 'category')
            ->get()
            ->map(fn ($medicine) => [
                'brand_name' => $medicine->name,
                'manufacturer' => $medicine->manufacturer->name,
                'generic_name' => $medicine->generic_name,
                'strength' => $medicine->strength,
                'category' => $medicine->category,
            ]);
    }
}
