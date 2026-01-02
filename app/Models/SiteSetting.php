<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SiteSetting extends Model
{
        protected $fillable = [
        'primary_color',
        'secondary_color',
        'text_color',
        'bg_color',
        'font_family',
    ];
}
