<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DailyStatus extends Model
{
    use HasFactory;

    // Define the specific database table name
    protected $table = 'daily_statuses';

    // Allow mass assignment on these fields
    protected $fillable = [
        'shop_id',
        'generated_text',
        'background_template_path',
        'custom_template_path',
        'final_flyer_url',
        'scheduled_for',
        'status',
        'template_theme',
        'font_style',
        'font_size', // Newly added field for template theme
    ];

    /**
     * Set up the inverse relationship back to the parent Shop.
     */
    public function shop()
    {
        return $this->belongsTo(Shop::class);
    }
}
