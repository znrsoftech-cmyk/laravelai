<?php

namespace App\Http\Controllers;

use App\Models\Shop;
use App\Models\DailyStatus;
use App\Services\StatusGenerationService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Database\QueryException;

class StatusDashboardController extends Controller
{
    /**
     * Display the mobile-first dashboard for a specific shopkeeper.
     */
    public function showDashboard($shopId)
    {
        $shop = Shop::findOrFail($shopId);

        // Fetch today's generated status entry
        $status = DailyStatus::where('shop_id', $shopId)
            ->whereDate('scheduled_for', now()->toDateString())
            ->first();

        return view('status.review', compact('shop', 'status'));
    }

    /**
     * An on-demand testing route to trigger Gemini AI generation instantly via browser.
     */
        public function forceGenerate(Request $request, $shopId, StatusGenerationService $statusService)
    {
        $shop = Shop::findOrFail($shopId);
        
        // Dynamic promo offer context to pass downstream to the AI
        $occasion = $request->get('occasion', 'Sunday Special 20% OFF Offer');

        try {
            // Wipe today's thin fallback record first
            \App\Models\DailyStatus::where('shop_id', $shopId)
                ->whereDate('scheduled_for', now()->toDateString())
                ->delete();

            // Run the service generation engine with the rich menu context vector
            $statusService->generateDailyContent($shop, $occasion);

            return redirect()->route('shop.dashboard', $shopId)
                ->with('success', 'AI status updated with fresh marketing copy!');
        } catch (\Exception $e) {
            return redirect()->route('shop.dashboard', $shopId)
                ->with('error', 'Generation Failed: ' . $e->getMessage());
        }
    }

    public function updateTheme(Request $request, $statusId)
    {
        $status = \App\Models\DailyStatus::findOrFail($statusId);
        
        $request->validate([
            'template_theme' => 'required|in:dark_slate,spicy_red,golden_glow,minimal_clean,ocean_blue,royal_plum'
        ]);

        // ONLY update the design theme column layer, keeping the generated text safe!
        $status->update([
            'template_theme' => $request->template_theme
        ]);

        return redirect()->route('shop.dashboard', $status->shop_id)
            ->with('success', 'Design theme updated instantly!');
    }
        /**
     * Update the generated status text and re-compile the flyer layers instantly.
     */
    public function saveAndRefresh(Request $request, $statusId)
    {
        $status = DailyStatus::findOrFail($statusId);
        
        $validated = $request->validate([
            'generated_text' => 'required|string'
        ]);

        // 1. Extract a punchy first line out of their text edits to use as the title text on the HTML flyer banner
        $lines = explode("\n", trim($request->generated_text));
        $firstLine = trim($lines[0]);
        
        // Strip out any trailing emojis or markdown from the heading block just in case to keep it neat
        $cleanFlyerHeading = mb_substr(preg_replace('/[^\p{L}\p{N}\s]/u', '', $firstLine), 0, 22);

        $changes = [
            'generated_text' => $request->generated_text,
            'background_template_path' => !empty($cleanFlyerHeading) ? $cleanFlyerHeading : 'SPECIAL OFFER'
        ];

        // SQLite can briefly remain write-locked while the local web server or
        // database viewer finishes a read. Retry only lock errors, not failures.
        $saved = false;
        for ($attempt = 0; $attempt < 3 && !$saved; $attempt++) {
            try {
                $status->update($changes);
                $saved = true;
            } catch (QueryException $exception) {
                $isLocked = str_contains(strtolower($exception->getMessage()), 'database is locked');
                if (!$isLocked || $attempt === 2) {
                    throw $exception;
                }

                usleep(500000);
                $status->refresh();
            }
        }

        // 3. Bounce the user right back to their active mobile dashboard workspace view smoothly
        return redirect()->route('shop.dashboard', $status->shop_id)
            ->with('success', 'Flyer graphic and text updated successfully!');
    }
    /**
     * NEW METHOD: Dynamically updates font families and typographic sizing constraints instantly
     */
    public function updateTypography(Request $request, $statusId)
    {
        $status = DailyStatus::findOrFail($statusId);
        $validated = $request->validate([
            'font_style' => 'required|in:modern_sans,classic_serif,luxury_display,playful_rounded',
            'font_size' => 'required|integer|min:16|max:42'
        ]);

        $status->update($validated);
        return redirect()->back()->with('success', 'Typography customization applied!');
    }

    public function uploadTemplate(Request $request, $statusId)
    {
        $status = DailyStatus::findOrFail($statusId);
        $shop = $status->shop;

        $validated = $request->validate([
            'template_image' => 'required|image|mimes:jpg,jpeg,png,webp|max:5120',
        ]);

        $directory = public_path($shop->customTemplateDirectory());
        if (!is_dir($directory) && !mkdir($directory, 0775, true) && !is_dir($directory)) {
            throw new \RuntimeException('Unable to create the shop-specific uploaded_templates directory.');
        }

        if ($status->custom_template_path) {
            $oldPath = public_path($status->custom_template_path);
            if (is_file($oldPath)) {
                unlink($oldPath);
            }
        }

        $extension = $validated['template_image']->extension();
        $fileName = 'template_' . $status->id . '_' . Str::random(12) . '.' . $extension;
        $validated['template_image']->move($directory, $fileName);

        $status->update([
            'custom_template_path' => $shop->customTemplateDirectory() . '/' . $fileName,
        ]);

        return redirect()->route('shop.dashboard', $status->shop_id)
            ->with('success', 'Your custom template was uploaded successfully!');
    }


}
