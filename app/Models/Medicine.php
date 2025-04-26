<?php

namespace App\Models;

use App\Models\Manufacturer;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Medicine extends Model
{
    use HasFactory;
    use SoftDeletes;

    public const UNIT = [
        'ml'    => 'Milliliter',
        'mg'    => 'Milligram',
        'pc'    => 'Pieces',
    ];


    protected $fillable = [
        'manufacturer_id',
        'name',
        'generic_name',
        'strength',
        'category',
        'unit',
        'purchase_price',
        'selling_price',
        'discount',
        'is_active'
    ];

    public const CATEGORY = [
        "Tablet" => "Tablet",
        "Capsule" => "Capsule",
        "Powder For Suspension" => "Powder For Suspension",
        "Syrup" => "Syrup",
        "Suspension" => "Suspension",
        "Pediatric Drops" => "Pediatric Drops",
        "Lotion" => "Lotion",
        "Ointment" => "Ointment",
        "Oral Saline" => "Oral Saline",
        "Cream" => "Cream",
        "Gel" => "Gel",
        "Suppository" => "Suppository",
        "Solution" => "Solution",
        "Bolus" => "Bolus",
        "Powder" => "Powder",
        "Water Soluble Powder" => "Water Soluble Powder",
        "Eye and Ear Drops" => "Eye and Ear Drops",
        "IM Injection" => "IM Injection",
        "IV Injection" => "IV Injection",
        "Injection" => "Injection",
        "IV/IM Injection" => "IV/IM Injection",
        "Eye, Ear & Nasal Drops" => "Eye, Ear & Nasal Drops",
        "Vaginal Tablet" => "Vaginal Tablet",
        "Eye Drops" => "Eye Drops",
        "Hand Rub" => "Hand Rub",
        "Oral Gel" => "Oral Gel",
        "Gargle & Mouth Wash" => "Gargle & Mouth Wash",
        "Oral Solution" => "Oral Solution",
        "Xr Tablet" => "Xr Tablet",
        "Sr Tablet" => "Sr Tablet",
        "Raw Materials" => "Raw Materials",
        "Pellets" => "Pellets",
        "Eye Ointment" => "Eye Ointment",
        "Mouth Wash" => "Mouth Wash",
        "Sr Capsule" => "Sr Capsule",
        "Aerosol Inhalation" => "Aerosol Inhalation",
        "Inhaler" => "Inhaler",
        "Inhalation Solution" => "Inhalation Solution",
        "IV Infusion" => "IV Infusion",
        "Ors Tablet" => "Ors Tablet",
        "Dispersible Tablet" => "Dispersible Tablet",
        "Orodispersible Tablet" => "Orodispersible Tablet",
        "Nebuliser Solution" => "Nebuliser Solution",
        "Oral Paste" => "Oral Paste",
        "Nasal Spray" => "Nasal Spray",
        "Spray" => "Spray",
        "Dr Tablet" => "Dr Tablet",
        "Cozycap" => "Cozycap",
        "Inhalation Aerosol" => "Inhalation Aerosol",
        "Inhalation Capsule" => "Inhalation Capsule",
        "Nasal Drops" => "Nasal Drops",
        "Chewable Tablet" => "Chewable Tablet",
        "Oral Powder" => "Oral Powder",
        "Topical Solution" => "Topical Solution",
        "Cr Tablet" => "Cr Tablet",
        "Er Tablet" => "Er Tablet",
        "Scalp Lotion" => "Scalp Lotion",
        "Oral Drops" => "Oral Drops",
        "Granules For Suspension" => "Granules For Suspension",
        "Liquid" => "Liquid",
        "Emulsion" => "Emulsion",
        "Oral Liquid" => "Oral Liquid",
        "Pellets For Suspension" => "Pellets For Suspension",
        "Sachet" => "Sachet",
        "Elixir" => "Elixir",
        "Linctus" => "Linctus",
        "Mups Tablet" => "Mups Tablet",
        "Sached Powder" => "Sached Powder",
        "Ear Drop" => "Ear Drop",
        "Eye & Nasal Drops" => "Eye & Nasal Drops",
        "Shampoo" => "Shampoo",
        "Ophthalmic Emulsion" => "Ophthalmic Emulsion",
        "Eye Gel" => "Eye Gel",
        "Solution For Injection" => "Solution For Injection",
        "Soft Gelatin Capsule" => "Soft Gelatin Capsule",
        "Solution For Infusion" => "Solution For Infusion",
        "Odt Tablet" => "Odt Tablet",
        "Irrigation Solution" => "Irrigation Solution",
        "Rectal Ointment" => "Rectal Ointment",
        "Resperitory Solution" => "Resperitory Solution",
        "Vaginal Cream" => "Vaginal Cream",
        "Respirator Suspension" => "Respirator Suspension",
        "Oral Soluble Film" => "Oral Soluble Film",
        "Emulgel" => "Emulgel",
        "Mouth Dissolving Tablet" => "Mouth Dissolving Tablet",
        "Oral Emulsion" => "Oral Emulsion",
        "Rapid Tablet" => "Rapid Tablet",
        "Powder for Pedriatric Drop" => "Powder for Pedriatric Drop",
        "Effervescent Granules" => "Effervescent Granules",
        "Mouth Wash Antiseptic" => "Mouth Wash Antiseptic",
        "Syringe" => "Syringe",
        "Dialysis Solution" => "Dialysis Solution",
        "Per Rectal" => "Per Rectal",
        "Vaginal Gel" => "Vaginal Gel",
        "Pr Tablet" => "Pr Tablet",
        "Dr Granules For Suspension" => "Dr Granules For Suspension",
        "Nebuliser Suspension" => "Nebuliser Suspension",
        "Er Capsule" => "Er Capsule",
        "Vaccine" => "Vaccine",
        "Gas" => "Gas",
        "Tincture" => "Tincture",
        "Scrub" => "Scrub",
        "Blood bag" => "Blood bag",
        "Pvc Bag" => "Pvc Bag",
        "Powder for Solution" => "Powder for Solution",
        "Pour On (Solution)" => "Pour On (Solution)",
        "Blood Tubing Set" => "Blood Tubing Set",
        "Needle for Syringe" => "Needle for Syringe",
        "Butterfly" => "Butterfly",
        "Powder For Oral Solution" => "Powder For Oral Solution",
        "Oral Granules" => "Oral Granules",
        "Eye Cleanser Solution" => "Eye Cleanser Solution",
        "Eye and Ear Ointment" => "Eye and Ear Ointment",
        "Vaginal Pessary" => "Vaginal Pessary",
        "Gum" => "Gum",
        "Oral Dental Gel" => "Oral Dental Gel",
        "Topical Suspension" => "Topical Suspension",
        "Cr Capsule" => "Cr Capsule",
        "Md Tablet" => "Md Tablet",
        "Inhalation Liquid" => "Inhalation Liquid",
        "Viscoelastic Solution" => "Viscoelastic Solution",
        "Drops" => "Drops",
        "Vaginal Suppository" => "Vaginal Suppository",
        "Scalp Ointment" => "Scalp Ointment",
        "Sprinkle Capsule" => "Sprinkle Capsule",
        "M R Capsule" => "M R Capsule",
        "M R Tablet" => "M R Tablet",
        "Repacking" => "Repacking"
    ];


    // Relations
    public function manufacturer()
    {
        return $this->belongsTo(Manufacturer::class);
    }

    public function stocks()
    {
        return $this->hasMany(Stock::class);
    }

    // Scopes
    public function scopeFilter($query, array $filters)
    {
        $query->when($filters['search'] ?? null, function ($query, $search): void {
            $query->where('name', 'like', $search . '%');
        });
    }
}
