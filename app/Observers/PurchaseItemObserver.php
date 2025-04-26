<?php

namespace App\Observers;

use App\Models\Medicine;
use App\Models\Stock;
use App\Models\PurchaseItem;
use Illuminate\Support\Facades\DB;

class PurchaseItemObserver
{
    public function created(PurchaseItem $purchaseItem): void
    {
        Stock::updateOrCreate(
            ['medicine_id' => $purchaseItem->medicine_id, 'batch_id' => $purchaseItem->batch_id],
            ['stock' => DB::raw('stock+' . $purchaseItem->quantity), 'expiry_date' => $purchaseItem->expiry_date]
        );

        Medicine::where('id', $purchaseItem->medicine_id)
            ->update([
                'purchase_price' => $purchaseItem->purchase_price,
                'selling_price' => $purchaseItem->selling_price,
            ]);
    }

    public function updated(PurchaseItem $purchaseItem): void
    {
        //
    }

    public function deleted(PurchaseItem $purchaseItem): void
    {
        //
    }


    public function restored(PurchaseItem $purchaseItem): void
    {
        //
    }


    public function forceDeleted(PurchaseItem $purchaseItem): void
    {
        //
    }
}
