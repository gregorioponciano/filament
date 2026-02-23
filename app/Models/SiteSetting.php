<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SiteSetting extends Model
{
    protected $fillable = [
        'bg_primary',
        'bg_secondary',
        'primary_color',
        'secondary_color',
        'menu_primary',
        'menu_secondary',
        'card_primary',
        'card_secondary',
        'link_primary',
        'link_secondary',
        'h1_primary',
        'h1-secondary',
        'h2_primary',
        'h2-secondary',
        'h3_primary',
        'h3-secondary',
        'text_primary',
        'text_secondary',
        'price_primary',
        'price_secondary',
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
