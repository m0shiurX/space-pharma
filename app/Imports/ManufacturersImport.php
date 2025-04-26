<?php

namespace App\Imports;

use App\Models\Manufacturer;
use Illuminate\Contracts\Queue\ShouldQueue;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithUpserts;

class ManufacturersImport implements ShouldQueue, ToModel, WithChunkReading, WithHeadingRow, WithUpserts
{
    use Importable;

    public function model(array $row)
    {
        return new Manufacturer([
            'name' => $row['manufacturer'],
            'location' => 'Bangladesh',
            'contact_name' => 'Contact Person',
            'contact_tel' => '+8801 XXX XXX XXX',
        ]);
    }

    public function chunkSize(): int
    {
        return 1000;
    }

    public function uniqueBy()
    {
        return 'name';
    }
}
