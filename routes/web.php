<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StatusDashboardController;
Route::get('/', function () {
    return view('welcome');
});



// 1. The Shopkeeper Dashboard view layout interface
Route::get('/shop/{shopId}/dashboard', [StatusDashboardController::class, 'showDashboard'])
    ->name('shop.dashboard');

// 2. The Dev test route to trigger Gemini content generation instantly
Route::get('/shop/{shopId}/generate-test', [StatusDashboardController::class, 'forceGenerate'])
    ->name('shop.generate.test');

Route::get('/chat', [\App\Http\Controllers\ChatController::class, 'index'])->name('chat.index');
Route::post('/chat/new', [\App\Http\Controllers\ChatController::class, 'newChat'])->name('chat.new');
Route::get('/chat/history', [\App\Http\Controllers\ChatController::class, 'history'])->name('chat.history');
Route::post('/chat/history/select', [\App\Http\Controllers\ChatController::class, 'selectHistory'])->name('chat.history.select');
Route::get('/chat/stream', [\App\Http\Controllers\ChatController::class, 'stream'])->name('chat.stream');

// Onboarding View Layout
Route::get('/onboarding', function() {
    return view('shop.onboarding');
})->name('shop.onboarding');

Route::get('/shop/onboarding', function() {
    return redirect()->route('shop.onboarding');
});

// Process Shop Registration Post
Route::post('/onboarding', function(Illuminate\Http\Request $request) {
    $validated = $request->validate([
        'shop_name' => 'required|string|max:255',
        'category' => 'required|string|max:255',
        'products_services' => 'required|string',
        'whatsapp_number' => 'required|string|max:20',
        'location' => 'required|string|max:255',
        'brand_style' => 'required|string',
        'source_language' => 'required|in:en,hi',
        'input_method' => 'required|in:text,voice',
    ]);

    $shop = \App\Models\Shop::create($validated);

    // Redirect straight to their brand new personalized mobile dashboard!
    return redirect()->route('shop.dashboard', $shop->id)
        ->with('success', 'Welcome to Daily Status Hub! Your marketing assistant is active.');
})->name('shop.store');
Route::post('/status/{statusId}/update-theme', [StatusDashboardController::class, 'updateTheme'])
    ->name('status.update.theme');
Route::post('/status/{statusId}/save-refresh', [StatusDashboardController::class, 'saveAndRefresh'])
    ->name('status.save.refresh');
Route::post('/status/{statusId}/update-typography', [StatusDashboardController::class, 'updateTypography'])
    ->name('status.update.typography');
Route::post('/status/{statusId}/upload-template', [StatusDashboardController::class, 'uploadTemplate'])
    ->name('status.upload.template');

