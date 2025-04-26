<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePurchaseRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            "invoice_no" => ['required', 'string'],
            "purchase_date" => ['date', 'required'],
            "manufacturer_id" => ['required', 'exists:manufacturers,id'],
            "sub_total" => ['numeric', 'required', 'min:1'],
            "vat" => ['numeric', 'required'],
            "vat_total" => ['numeric', 'required'],
            "discount" => ['numeric', 'required'],
            "grand_total" => ['numeric', 'required', 'min:1'],
            "paid_amount" => ['numeric', 'required'],
            "due_amount" => ['numeric', 'required'],
            "purchase_items.*.id" => ['required', 'exists:medicines,id'],
            "purchase_items.*.batch_id" => ['string', 'required'],
            "purchase_items.*.expiry_date" => ['date', 'after:tomorrow', 'required'],
            "purchase_items.*.quantity" => ['numeric', 'required'],
            "purchase_items.*.purchase_price" => ['numeric', 'required'],
            "purchase_items.*.selling_price" => ['numeric', 'required'],
            "purchase_items.*.vat" => ['numeric', 'required'],
            "purchase_items.*.total_price" => ['numeric', 'required'],
        ];
    }
}
