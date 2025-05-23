<?php

namespace App\Imports;

use App\Models\Manufacturer;
use App\Models\Medicine;
use Illuminate\Contracts\Queue\ShouldQueue;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithUpserts;

class MedicinesImport implements ShouldQueue, ToModel, WithChunkReading, WithHeadingRow, WithUpserts
{
    use Importable;

    private $manufacturers;

    public function __construct()
    {
        $this->manufacturers = Manufacturer::all(['id', 'name'])->pluck('id', 'name');
    }

    public function model(array $row)
    {

        return new Medicine([
            'manufacturer_id' => $this->manufacturers[$row['manufacturer']],
            'name' => $row['brand_name'],
            'generic_name' => $row['generic_name'],
            'strength' => $row['strength'],
            'category' => $row['category'],
            'unit' => 'pcs',
            'purchase_price' => 0,
            'selling_price' => 0,
            'discount' => 0,
        ]);
    }

    public function chunkSize(): int
    {
        return 2000;
    }

    public function uniqueBy()
    {
        return 'name';
    }
}
