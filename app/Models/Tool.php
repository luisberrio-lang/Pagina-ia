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
        'price_monthly','price_semestral','price_anual',
        'savings_semestral','savings_anual',
        'sort_order','is_active',
    ];

    protected $casts = [
        'highlights' => 'array',
        'includes'   => 'array',
        'extras'     => 'array',
        'is_active'  => 'boolean',
        'sort_order' => 'integer',
        'price_monthly'    => 'decimal:2',
        'price_semestral'  => 'decimal:2',
        'price_anual'      => 'decimal:2',
        'savings_semestral'=> 'decimal:2',
        'savings_anual'    => 'decimal:2',
    ];
}
