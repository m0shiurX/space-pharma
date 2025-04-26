<?php

namespace App\Observers;

use App\Models\SalesItem;
use Illuminate\Support\Facades\DB;

class SalesItemObserver
{
    public function created(SalesItem $salesItem): void
    {
        DB::table('stocks')
            ->where('medicine_id', $salesItem->medicine_id)
            ->where('id', $salesItem->batch_id)
            ->decrement('stock', $salesItem->quantity);
    }

    public function updated(SalesItem $salesItem): void
    {
        //
    }

    public function deleted(SalesItem $salesItem): void
    {
        //
    }

    public function restored(SalesItem $salesItem): void
    {
        //
    }

    public function forceDeleted(SalesItem $salesItem): void
    {
        //
    }
}
