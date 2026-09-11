<?php

namespace Tests\Unit;

use App\Models\Shop;
use PHPUnit\Framework\TestCase;

class ShopTemplateThemeTest extends TestCase
{
    public function test_each_shop_resolves_a_different_default_template_theme(): void
    {
        $shopA = new Shop([
            'id' => 1,
            'shop_name' => 'Alpha Kitchen',
            'category' => 'Restaurant',
            'products_services' => 'Biryani, Kebabs, Naan',
            'whatsapp_number' => '+910000000001',
            'location' => 'Noida',
            'brand_style' => 'traditional',
        ]);

        $shopB = new Shop([
            'id' => 2,
            'shop_name' => 'Beta Kitchen',
            'category' => 'Cafe',
            'products_services' => 'Coffee, Sandos, Pasta',
            'whatsapp_number' => '+910000000002',
            'location' => 'Delhi',
            'brand_style' => 'modern',
        ]);

        $this->assertNotSame($shopA->defaultTemplateTheme(), $shopB->defaultTemplateTheme());
    }
}
