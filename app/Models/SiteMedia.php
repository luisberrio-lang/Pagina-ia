<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SiteMedia extends Model
{
    protected $table = 'site_media';

    protected $fillable = [
        'key',
        'path',
        'mime',
        'original_name',
        'size_bytes',
        'active',
    ];
}
