<?php
namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Shop;

class ShopSeeder extends Seeder
{
    public function run(): void
    {
        // Profile 1: Fast Food / Casual Cafe Vibe
        Shop::create([
            'shop_name' => 'The Pizza Corner',
            'category' => 'Fast Food Cafe',
            'products_services' => 'Wood-fired pepperoni pizza, cheesy garlic bread, peri-peri fries, artisanal milkshakes',
            'whatsapp_number' => '+919876543210',
            'location' => 'Sector 62, Noida',
            'brand_style' => 'energetic and casual'
        ]);

        // Profile 2: Multi-cuisine Fine Dining Vibe
        Shop::create([
            'shop_name' => 'Royal Biryani Kitchen',
            'category' => 'Traditional Awadhi Restaurant',
            'products_services' => 'Mutton biryani, chicken tikka masala, garlic naan, cold kesar phirni',
            'whatsapp_number' => '+919876543211',
            'location' => 'Hazratganj, Lucknow',
            'brand_style' => 'royal, traditional, and welcoming'
        ]);

        // Profile 3: Modern Health Cafe Vibe
        Shop::create([
            'shop_name' => 'The Daily Grind & Bakery',
            'category' => 'Boutique Bakery & Cafe',
            'products_services' => 'Fresh sourdough bread, avocado sourdough toast, iced vanilla lattes, sugar-free croissants',
            'whatsapp_number' => '+919876543212',
            'location' => 'Indiranagar, Bengaluru',
            'brand_style' => 'minimalist, professional, and health-focused'
        ]);
    }
}
