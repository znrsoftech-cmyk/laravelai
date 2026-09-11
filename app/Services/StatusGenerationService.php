<?php

namespace App\Services;

use App\Models\DailyStatus;
use App\Models\Shop;
use Illuminate\Support\Facades\Http;
use Intervention\Image\Laravel\Facades\Image;

class StatusGenerationService
{
    public function generateDailyContent(Shop $shop, string $todayOccasion = 'Regular Business Day'): DailyStatus
    {
                // 1. Hyper-strict copywriting prompt parameters tailored to prevent Gemini prompt leaks
                // 1. Production-grade clear format structure for Gemini 3.6
                // 1. Structural, leak-proof prompt template configuration for Gemini
                // 1. Premium prompt architecture designed for fancy, high-end copy
        $prompt = "You are an elite, Michelin-star level marketing copywriter for premium restaurants in India. 
                   Write an incredibly mouth-watering, elegant, and high-energy WhatsApp Status caption for:
                   - Restaurant Name: '{$shop->shop_name}'
                   - Category: '{$shop->category}'
                   - Special Star Dishes: '{$shop->products_services}'
                   - Location: '{$shop->location}'
                   - Vibe: Luxury, premium, and irresistible
                   - Today's Occasion/Promo Context: '{$todayOccasion}'
                   
                   STRICT COPYWRITING TEMPLATE (Follow this tone exactly):
                   ✨ [Catchy elite hook sentence using a blend of sophisticated English and warm, inviting Hinglish, e.g., 'Craving something extraordinary today?']
                   🔥 [Mouth-watering description sentence of the dishes, highlighting freshness, taste, and premium ingredients. Accentuate with 2-3 premium food emojis]
                   👉 [Elegant Call to Action: 'Exclusively available at {$shop->location}. Tap to chat or message us directly on WhatsApp to order now: {$shop->whatsapp_number}']
                   
                   STRICT FORMATTING RULE: Do NOT include markdown tags, bullet markers, labels, headers, asterisks, or system formatting code.";





        $apiKey = config('ai.providers.gemini.key');
        $geminiUrl = rtrim(config('ai.providers.gemini.url'), '/');
        $model = config('ai.providers.gemini.model', 'gemini-3.6-flash');

        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
        ])->withQueryParameters([
            'key' => $apiKey,
        ])->connectTimeout(5)->timeout(20)->post("{$geminiUrl}/models/{$model}:generateContent", [
            'contents' => [
                'parts' => [
                    ['text' => $prompt],
                ],
            ],
            'generationConfig' => [
                'temperature' => 0.7,
                'maxOutputTokens' => 200,
            ],
        ]);

        $isQuotaResponse = $response->status() === 429
            || ($response->status() === 403 && str_contains(strtolower($response->body()), 'quota'));

        if ($response->failed() && !$isQuotaResponse) {
            throw new \RuntimeException(
                'Gemini HTTP Error: Status ' . $response->status() . ' - ' . $response->body()
            );
        }

        $captionText = $isQuotaResponse
            ? $this->fallbackCaption($shop, $todayOccasion)
            : $response->json('candidates.0.content.parts.0.text');

        if (!is_string($captionText) || trim($captionText) === '') {
            throw new \RuntimeException('Gemini returned no caption text.');
        }

        $captionText = trim(str_replace(['**', '*'], '', $captionText));
        if (mb_strlen($captionText) < 20) {
            $captionText = $this->fallbackCaption($shop, $todayOccasion);
        }
        $templateFile = public_path('templates/' . strtolower(str_replace(' ', '_', $todayOccasion)) . '.jpg');
        if (!is_file($templateFile)) {
            $templateFile = public_path('templates/default_restaurant.jpg');
        }

        if (!is_file($templateFile)) {
            throw new \RuntimeException('No flyer template was found in public/templates.');
        }
        $image = Image::decodePath($templateFile)->cover(1080, 1920);
        $boldFont = $this->resolveFont('Montserrat-Bold.ttf', [
            'C:/Windows/Fonts/arialbd.ttf',
            '/usr/share/fonts/truetype/dejavu/DejaVuSans-Bold.ttf',
        ]);
        $regularFont = $this->resolveFont('Montserrat-Medium.ttf', [
            'C:/Windows/Fonts/arial.ttf',
            '/usr/share/fonts/truetype/dejavu/DejaVuSans.ttf',
        ]);

        // HEADER: Render Shop Name on Header Banner area
                // 4. Clean Header Typography Drawing Layout (Windows Absolute Path Compliant)
        $boldFontPath = realpath(public_path('fonts/Montserrat-Bold.ttf'));
        $mediumFontPath = realpath(public_path('fonts/Montserrat-Medium.ttf'));
        $fontFileBold = $boldFontPath ? $boldFontPath : public_path('fonts/Montserrat-Bold.ttf');
        $fontFileMedium = $mediumFontPath ? $mediumFontPath : public_path('fonts/Montserrat-Medium.ttf');

        // HEADER LINE 1: Restaurant/Shop Name (Positioned cleanly at Y=120)
        $image->text(strtoupper($shop->shop_name), 540, 120, function($font) use ($fontFileBold) {
            $font->file($fontFileBold);
            $font->size(44); 
            $font->color('#ffffff'); // Solid high-contrast white text
            $font->align('center');
        });

        // HEADER LINE 2: Today's Dynamic Event Occasion (Shifted to Y=220 to avoid overlap)
        $image->text(strtoupper($todayOccasion), 540, 220, function($font) use ($fontFileBold) {
            $font->file($fontFileBold);
            $font->size(36);
            $font->color('#ffcc00'); // Vibrant yellow accent color to pop over dark visuals
            $font->align('center');
        });

        // FOOTER CALL TO ACTION (Positioned safely over the bottom footer bar)
        $image->text("Order on WhatsApp: " . $shop->whatsapp_number, 540, 1800, function($font) use ($fontFileMedium) {
            $font->file($fontFileMedium);
            $font->size(34);
            $font->color('#ffffff');
            $font->align('center');
        });


        $image->text($captionText, 540, 1020, function($font) use ($regularFont): void {
            $font->file($regularFont);
            $font->size(34);
            $font->color('#ffffff');
            $font->align('center', 'center');
            $font->wrap(820);
        });

        $directory = public_path('generated_status');
        if (!is_dir($directory) && !mkdir($directory, 0775, true) && !is_dir($directory)) {
            throw new \RuntimeException('Unable to create the generated_status directory.');
        }

        $fileName = 'flyer_' . $shop->id . '_' . time() . '.jpg';
        $savePath = $directory . DIRECTORY_SEPARATOR . $fileName;
        $image->save($savePath);

        return DailyStatus::create([
            'shop_id' => $shop->id,
            'generated_text' => $captionText,
            'background_template_path' => $templateFile,
            'final_flyer_url' => asset('generated_status/' . $fileName),
            'scheduled_for' => now()->toDateString(),
            'status' => 'pending',
            'template_theme' => $shop->defaultTemplateTheme(),
        ]);
    }

    private function resolveFont(string $projectFont, array $fallbacks): string
    {
        foreach (array_merge([public_path('fonts/' . $projectFont)], $fallbacks) as $fontPath) {
            if (is_file($fontPath) && filesize($fontPath) > 0) {
                return $fontPath;
            }
        }

        throw new \RuntimeException('No readable TrueType font was found for flyer generation.');
    }

    private function fallbackCaption(Shop $shop, string $todayOccasion): string
    {
        return "🍕 {$todayOccasion} ka tasty special offer aa gaya hai! "
            . "{$shop->shop_name} par fresh flavours enjoy karein. "
            . "Order karein: {$shop->whatsapp_number}";
    }
}
