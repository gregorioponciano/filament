<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SiteSetting extends Model
{
    protected $fillable = [
        'primary_color',
        'secondary_color',
        'text_color',
        'bg_color',
        'border_color',
        'link_color',
        'hover_color',
        'footer_color',
        'footer_text_color',
        'font_family',
    ];
}
