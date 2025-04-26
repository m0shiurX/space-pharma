<?php

namespace App\Models;

use DateTimeInterface;
use App\Models\Medicine;
use App\Models\Purchase;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PurchaseItem extends Model
{
    use HasFactory;
    use SoftDeletes;


    protected $fillable = [
        'purchase_id',
        'medicine_id',
        'batch_id',
        'expiry_date',
        'quantity',
        'vat',
        'purchase_price',
        'selling_price',
        'total_price',
    ];

    protected $casts = [
        'expiry_date' => 'date'
    ];


    public function medicine()
    {
        return $this->belongsTo(Medicine::class);
    }

    public function purchase()
    {
        return $this->belongsTo(Purchase::class);
    }

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }
}
