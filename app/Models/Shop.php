<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shop extends Model
{
    use HasFactory;

    protected $fillable = [
        'shop_name',
        'category',
        'products_services',
        'whatsapp_number',
        'location',
        'brand_style'
    ];

    /**
     * Return a deterministic, shop-specific default flyer theme.
     * This keeps every shop visually distinct while remaining stable.
     */
    public function defaultTemplateTheme(): string
    {
        $themes = [
            'dark_slate',
            'spicy_red',
            'golden_glow',
            'minimal_clean',
            'ocean_blue',
        ];

        $seed = (int) ($this->id ?? crc32($this->shop_name ?? 'default-shop'));
        $themeIndex = abs($seed) % count($themes);

        return $themes[$themeIndex];
    }

    /**
     * Return a shop-scoped uploaded template directory.
     * Ensures each shop stores uploaded custom templates separately.
     */
    public function customTemplateDirectory(): string
    {
        return 'uploaded_templates/shop_' . ($this->id ?? 0);
    }

    /**
     * Get all daily statuses generated for this local shop.
     */
    public function dailyStatuses()
    {
        return $this->hasMany(DailyStatus::class);
    }
}
