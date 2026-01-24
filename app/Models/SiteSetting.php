<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SiteSetting extends Model
{
    protected $fillable = [
        'bg_color',
        'primary_color',
        'secondary_color',
        'card_primary',
        'card_secondary',
        'link_primary',
        'link_secondary',
        'h1_color',
        'h2_color',
        'h3_color',
        'text_primary',
        'text_secondary',
        'text_price',
        'button_primary',
        'button_secondary',
        'input_primary',
        'input_secondary',
        'hover_primary',
        'hover_secondary',
        'border_primary',
        'border_secondary',
        'footer_color',
        'footer_text_color',
        'font_family',
    ];
}
