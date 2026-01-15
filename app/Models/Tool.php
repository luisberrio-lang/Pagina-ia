<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tool extends Model
{
    use HasFactory;

    protected $fillable = [
        'tag','title','subtitle','short_desc','badge_text',
        'highlights','includes','extras','audience',
        'price_monthly','price_bimestral','price_trimestral','price_semestral','price_anual',
        'old_price_monthly','old_price_bimestral','old_price_trimestral','old_price_semestral','old_price_anual',
        'price_monthly_old','price_bimestral_old','price_trimestral_old','price_semestral_old','price_anual_old',
        'off_monthly','off_bimestral','off_trimestral','off_semestral','off_anual',
        'off_mensual',
        'sort_order','is_active',
    ];

    protected $casts = [
        'highlights' => 'array',
        'includes'   => 'array',
        'extras'     => 'array',
        'is_active'  => 'boolean',
        'sort_order' => 'integer',

        'price_monthly'     => 'decimal:2',
        'price_bimestral'   => 'decimal:2',
        'price_trimestral'  => 'decimal:2',
        'price_semestral'   => 'decimal:2',
        'price_anual'       => 'decimal:2',

        'old_price_monthly'     => 'decimal:2',
        'old_price_bimestral'   => 'decimal:2',
        'old_price_trimestral'  => 'decimal:2',
        'old_price_semestral'   => 'decimal:2',
        'old_price_anual'       => 'decimal:2',
        'price_monthly_old'     => 'decimal:2',
        'price_bimestral_old'   => 'decimal:2',
        'price_trimestral_old'  => 'decimal:2',
        'price_semestral_old'   => 'decimal:2',
        'price_anual_old'       => 'decimal:2',

        'off_monthly'    => 'integer',
        'off_bimestral'  => 'integer',
        'off_trimestral' => 'integer',
        'off_semestral'  => 'integer',
        'off_anual'      => 'integer',
        'off_mensual'    => 'integer',
    ];

    public function getOldPriceMonthlyAttribute(): ?string
    {
        return $this->attributes['old_price_monthly']
            ?? $this->attributes['price_monthly_old']
            ?? null;
    }

    public function getOldPriceBimestralAttribute(): ?string
    {
        return $this->attributes['old_price_bimestral']
            ?? $this->attributes['price_bimestral_old']
            ?? null;
    }

    public function getOldPriceTrimestralAttribute(): ?string
    {
        return $this->attributes['old_price_trimestral']
            ?? $this->attributes['price_trimestral_old']
            ?? null;
    }

    public function getOldPriceSemestralAttribute(): ?string
    {
        return $this->attributes['old_price_semestral']
            ?? $this->attributes['price_semestral_old']
            ?? null;
    }

    public function getOldPriceAnualAttribute(): ?string
    {
        return $this->attributes['old_price_anual']
            ?? $this->attributes['price_anual_old']
            ?? null;
    }

    public function getOffMonthlyAttribute(): ?int
    {
        return $this->attributes['off_monthly']
            ?? $this->attributes['off_mensual']
            ?? null;
    }

    public function getOffBimestralAttribute(): ?int
    {
        return $this->attributes['off_bimestral'] ?? null;
    }

    public function getOffTrimestralAttribute(): ?int
    {
        return $this->attributes['off_trimestral'] ?? null;
    }

    public function getOffSemestralAttribute(): ?int
    {
        return $this->attributes['off_semestral'] ?? null;
    }

    public function getOffAnualAttribute(): ?int
    {
        return $this->attributes['off_anual'] ?? null;
    }
}
