<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateMedicineRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'manufacturer_id' => ['numeric', 'required'],
            'name' => ['string', 'required', Rule::unique('medicines')->ignore($this->medicine)],
            'generic_name' => ['string'],
            'strength' => ['nullable'],
            'category' => ['required'],
            'unit' => ['required'],
            'purchase_price' => ['numeric', 'required'],
            'selling_price' => ['numeric', 'required'],
            'discount' => ['required', 'numeric', 'between:0,30'],
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'purchase_price' => number_format($this->purchase_price, 2),
            'selling_price' => number_format($this->selling_price, 2),
            'discount' => number_format($this->discount, 2),
        ]);
    }
}
