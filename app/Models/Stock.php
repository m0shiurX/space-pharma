<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Stock extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $casts = [
        'expiry_date' => 'date:Y-m-d'
    ];

    protected $fillable = [
        'medicine_id',
        'batch_id',
        'expiry_date',
        'stock',
    ];


    public function medicine()
    {
        return $this->belongsTo(Medicine::class);
    }

    // Scopes
    public function scopeFilter($query, array $filters)
    {
        $query->when($filters['search'] ?? null, function ($query, $search): void {
            $query->whereHas('medicine', function ($query) use ($search): void {
                $query->where('name', 'like', $search . '%');
            });
        });
    }
}
