<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SalesItem extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'sale_id',
        'medicine_id',
        'batch_id',
        'quantity',
        'selling_price',
        'discount',
        'total_price',
    ];


    public function medicine()
    {
        return $this->belongsTo(Medicine::class);
    }


    public function sale()
    {
        return $this->belongsTo(Sale::class);
    }


    // public function setSellingPriceAttribute($value)
    // {
    //     return $this->attributes['selling_price'] = number_format($value, 2);
    // }

    // public function setTotalPriceAttribute($value)
    // {
    //     return $this->attributes['total_price'] = number_format($value, 2);
    // }

    // public function setDiscountAttribute($value)
    // {
    //     return $this->attributes['discount'] = number_format($value, 2);
    // }
}
