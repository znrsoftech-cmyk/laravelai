<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daily Status Hub</title>
    <script src="https://cdn.jsdelivr.net/npm/html2canvas@1.4.1/dist/html2canvas.min.js"></script>
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; font-family: 'SF Pro Display', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif; }
        body { background: radial-gradient(circle at top left, #1e1b4b 0%, #020617 100%); display: flex; align-items: center; justify-content: center; min-height: 100vh; padding: 12px; }
        
        /* Premium, High-End Mobile Canvas Phone Frame Frame */
        .phone-container { width: 100%; max-width: 415px; background: rgba(15, 23, 42, 0.6); backdrop-filter: blur(20px); -webkit-backdrop-filter: blur(20px); min-height: 860px; border-radius: 40px; box-shadow: 0 30px 60px -15px rgba(0, 0, 0, 0.8), inset 0 1px 2px rgba(255, 255, 255, 0.1); border: 1px solid rgba(255, 255, 255, 0.08); display: flex; flex-direction: column; padding: 24px; overflow: hidden; position: relative; }
        
        header { border-b: 1px solid rgba(255, 255, 255, 0.06); border-bottom: 1px solid rgba(255, 255, 255, 0.06); padding-bottom: 16px; margin-bottom: 20px; display: flex; justify-content: space-between; align-items: center; }
        h1 { font-size: 20px; font-weight: 800; color: #ffffff; letter-spacing: -0.5px; text-shadow: 0 2px 4px rgba(0,0,0,0.3); }
        .tag { font-size: 11px; font-weight: 700; color: #34d399; background-color: rgba(52, 211, 153, 0.1); padding: 4px 10px; border-radius: 8px; margin-top: 4px; display: inline-block; border: 1px solid rgba(52, 211, 153, 0.15); text-transform: uppercase; letter-spacing: 0.5px; }
        
        /* ULTRA-FANCY GRADIENT FLYER CANVAS BLOCKS */
        .live-flyer { width: 100%; aspect-ratio: 9/16; max-height: 480px; border-radius: 24px; border: 4px solid #ffffff; box-shadow: 0 20px 40px rgba(0,0,0,0.4); display: flex; flex-direction: column; justify-content: space-between; padding: 28px 22px; text-align: center; margin-bottom: 20px; position: relative; transition: all 0.3s ease; overflow: hidden; }
        .live-flyer > div { position: relative; z-index: 1; }
        .custom-template-image { position: absolute; inset: 0; z-index: 0; width: 100%; height: 100%; object-fit: cover; object-position: center; }
        
        .flyer-header { font-size: 26px; font-weight: 900; letter-spacing: 0.5px; text-transform: uppercase; text-shadow: 0 3px 6px rgba(0,0,0,0.5), 0 0 20px rgba(255,255,255,0.2); }
        .flyer-occasion { font-size: 14px; font-weight: 800; margin-top: 6px; text-transform: uppercase; letter-spacing: 2px; text-shadow: 0 2px 4px rgba(0,0,0,0.4); padding: 4px 12px; background: rgba(0,0,0,0.2); display: inline-block; border-radius: 50px; backdrop-filter: blur(5px); }
        
        /* Custom Glowing Graphic Asset Placeholders inside the Poster */
        .graphic-display-box { width: 90%; aspect-ratio: 4/3; margin: auto; border-radius: 20px; display: flex; align-items: center; justify-content: center; position: relative; overflow: hidden; box-shadow: 0 12px 24px rgba(0,0,0,0.3); }
        .graphic-glow-circle { width: 100px; height: 100px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 58px; animation: pulse 3s infinite ease-in-out; filter: drop-shadow(0 0 15px rgba(255,255,255,0.3)); }
        
        .flyer-footer { font-size: 13px; font-weight: 800; color: #ffffff; padding: 10px 20px; border-radius: 50px; display: inline-block; margin: 0 auto; letter-spacing: 0.5px; text-transform: uppercase; box-shadow: 0 4px 12px rgba(0,0,0,0.2); border: 1px solid rgba(255,255,255,0.1); }
        
        .caption-title { font-size: 11px; font-weight: 800; color: #94a3b8; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 8px; padding-left: 2px; }
        
        /* Modern Glassmorphic Inputs */
        .caption-box { background: rgba(255, 255, 255, 0.03); border: 1px solid rgba(255, 255, 255, 0.08); border-radius: 20px; padding: 14px; min-height: 100px; display: flex; margin-bottom: 16px; box-shadow: inset 0 2px 4px rgba(0,0,0,0.2); transition: all 0.3s ease; }
        .caption-box:focus-within { border-color: #6366f1; background: rgba(255, 255, 255, 0.05); box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.15); }
        #captionText { width: 100%; border: none; line-height: 1.45; color: #e2e8f0; font-weight: 500; resize: none; outline: none; background: transparent; }

        .dashboard-controls { display: flex; flex-direction: column; align-items: flex-end; gap: 7px; }
        .control-select { min-height: 30px; border: 1px solid #cbd5e1; border-radius: 7px; padding: 5px 8px; font-size: 12px; color: #334155; background: #f8fafc; cursor: pointer; }
        .theme-select { min-height: 32px; border: 0; border-radius: 8px; padding: 7px 10px; font-size: 12px; font-weight: 700; color: #4f46e5; background: #e0e7ff; cursor: pointer; }
        .typography-controls { display: flex; flex-wrap: wrap; justify-content: flex-end; gap: 5px; }
        .typography-submit { min-height: 30px; border: 0; border-radius: 7px; padding: 5px 9px; font-size: 12px; font-weight: 700; color: #ffffff; background: #6366f1; cursor: pointer; }
        .template-upload { display: flex; flex-wrap: wrap; justify-content: flex-end; align-items: center; gap: 5px; max-width: 250px; }
        .template-upload label { font-size: 10px; font-weight: 700; color: #cbd5e1; }
        .template-upload input[type="file"] { width: 150px; min-height: 28px; color: #cbd5e1; font-size: 10px; }
        .template-upload button { min-height: 28px; border: 0; border-radius: 7px; padding: 5px 8px; font-size: 11px; font-weight: 700; color: #ffffff; background: #0ea5e9; cursor: pointer; }
        
        /* Fancy Interactive Action Button Controls Layout Matrix */
        .btn-save { width: 100%; background: rgba(255, 255, 255, 0.06); border: 1px solid rgba(255, 255, 255, 0.1); color: #cbd5e1; font-size: 13px; font-weight: 700; padding: 13px; border-radius: 16px; cursor: pointer; transition: all 0.2s ease; display: flex; align-items: center; justify-content: center; gap: 8px; }
        .btn-save:hover { background: rgba(255, 255, 255, 0.1); color: #ffffff; border-color: rgba(255, 255, 255, 0.2); }
        
        .btn-download { width: 100%; background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%); color: white; border: none; font-size: 14px; font-weight: 700; padding: 15px; border-radius: 16px; cursor: pointer; display: flex; align-items: center; justify-content: center; gap: 8px; box-shadow: 0 8px 20px rgba(59, 130, 246, 0.25); margin-top: 12px; transition: all 0.2s ease; }
        .btn-download:active, .whatsapp-btn:active { transform: scale(0.98); }
        
        .whatsapp-btn { width: 100%; background: linear-gradient(135deg, #10b981 0%, #047857 100%); color: white; border: none; font-size: 15px; font-weight: 800; padding: 16px; border-radius: 16px; cursor: pointer; box-shadow: 0 10px 25px rgba(16, 185, 129, 0.3); display: flex; align-items: center; justify-content: center; gap: 10px; margin-top: 12px; transition: all 0.2s ease; }
        
        .force-btn { width: 100%; background: transparent; border: none; color: #475569; font-size: 11px; font-weight: 700; padding: 10px; cursor: pointer; text-transform: uppercase; letter-spacing: 0.5px; margin-top: auto; text-align: center; }
        .force-btn:hover { color: #94a3b8; }

        @keyframes pulse {
            0% { transform: scale(1); opacity: 0.9; }
            50% { transform: scale(1.05); opacity: 1; box-shadow: 0 0 25px rgba(255,255,255,0.1); }
            100% { transform: scale(1); opacity: 0.9; }
        }

        @media (max-width: 420px) {
            body { padding: 6px; }
            .phone-container { min-height: calc(100vh - 12px); padding: 16px; border-radius: 28px; }
            header { align-items: flex-start; gap: 10px; }
            .dashboard-controls { max-width: 58%; }
            .typography-controls { justify-content: flex-end; }
            .control-select { max-width: 92px; }
            .template-upload { max-width: 190px; }
            .template-upload input[type="file"] { width: 120px; }
            .live-flyer { padding: 24px 16px; margin-bottom: 16px; }
        }
    </style>

</head>
<body>

    <div class="phone-container">
        
        <!-- Status Notification Popup Banner Alerts -->
        <?php if(session('success')): ?>
            <div style="margin-bottom: 12px; padding: 10px 15px; background-color: #10b981; color: white; font-size: 12px; font-weight: 700; border-radius: 10px; box-shadow: 0 4px 6px rgba(0,0,0,0.05);">
                ✨ <?php echo e(session('success')); ?>

            </div>
        <?php endif; ?>
        <?php if(session('error')): ?>
            <div style="margin-bottom: 12px; padding: 10px 15px; background-color: #ef4444; color: white; font-size: 12px; font-weight: 700; border-radius: 10px;">
                ❌ <?php echo e(session('error')); ?>

            </div>
        <?php endif; ?>

        <!-- Header Panel Area -->
        <header>
            <div>
                <h1><?php echo e($shop->shop_name); ?></h1>
                <div class="tag"><?php echo e($shop->category); ?></div>
            </div>
            <?php if($status): ?>
                <!-- 🎨 MULTI-TEMPLATE DROPDOWN SWITCHER COMPONENT -->
                <div class="dashboard-controls">
                    <form action="<?php echo e(route('status.update.theme', $status->id)); ?>" method="POST" id="themeForm">
                        <?php echo csrf_field(); ?>
                        <select class="theme-select" name="template_theme" onchange="document.getElementById('themeForm').submit()">
                            <option value="dark_slate" <?php echo e($status->template_theme == 'dark_slate' ? 'selected' : ''); ?>>Midnight Slate</option>
                            <option value="spicy_red" <?php echo e($status->template_theme == 'spicy_red' ? 'selected' : ''); ?>>Spicy Crimson</option>
                            <option value="golden_glow" <?php echo e($status->template_theme == 'golden_glow' ? 'selected' : ''); ?>>Festive Gold</option>
                            <option value="minimal_clean" <?php echo e($status->template_theme == 'minimal_clean' ? 'selected' : ''); ?>>Mint Clean</option>
                        </select>
                    </form>
                    <form class="typography-controls" action="<?php echo e(route('status.update.typography', $status->id)); ?>" method="POST" id="typographyForm">
                        <?php echo csrf_field(); ?>
                        <select class="control-select" name="font_style" aria-label="Font style">
                            <option value="modern_sans" <?php echo e(($status->font_style ?? 'classic_serif') === 'modern_sans' ? 'selected' : ''); ?>>Sans</option>
                            <option value="classic_serif" <?php echo e(($status->font_style ?? 'classic_serif') === 'classic_serif' ? 'selected' : ''); ?>>Serif</option>
                            <option value="luxury_display" <?php echo e(($status->font_style ?? 'classic_serif') === 'luxury_display' ? 'selected' : ''); ?>>Display</option>
                            <option value="playful_rounded" <?php echo e(($status->font_style ?? 'classic_serif') === 'playful_rounded' ? 'selected' : ''); ?>>Rounded</option>
                        </select>
                        <select class="control-select" name="font_size" aria-label="Font size">
                            <?php $__currentLoopData = [16, 20, 24, 28, 32, 36, 40]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $fontSize): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($fontSize); ?>" <?php echo e((int) ($status->font_size ?? 24) === $fontSize ? 'selected' : ''); ?>><?php echo e($fontSize); ?>px</option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                        <button class="typography-submit" type="submit" aria-label="Apply typography">Apply</button>
                    </form>
                    <form class="template-upload" action="<?php echo e(route('status.upload.template', $status->id)); ?>" method="POST" enctype="multipart/form-data">
                        <?php echo csrf_field(); ?>
                        <label for="templateImage">Use your image</label>
                        <input id="templateImage" type="file" name="template_image" accept="image/jpeg,image/png,image/webp" required>
                        <button type="submit">Upload</button>
                    </form>
                </div>
            <?php else: ?>
                <span class="badge" style="background-color: #e2e8f0; color: #64748b;">Pending</span>
            <?php endif; ?>
        </header>

        <?php if($status): ?>
            <?php
                // CSS THEME PROPERTIES MATRIX LAYER MAPS
                $currentTheme = $status->template_theme ?? 'dark_slate';
                
                $themes = [
                    'dark_slate' => [
                        'bg' => 'linear-gradient(135deg, #1e1b4b 0%, #0f172a 100%)',
                        'header_color' => '#ffffff', 'occasion_color' => '#ffcc00', 'footer_bg' => 'rgba(255,255,255,0.1)', 'icon' => '🍕'
                    ],
                    'spicy_red' => [
                        'bg' => 'linear-gradient(135deg, #991b1b 0%, #450a0a 100%)',
                        'header_color' => '#ffffff', 'occasion_color' => '#fde047', 'footer_bg' => 'rgba(0,0,0,0.2)', 'icon' => '🌶️🍔'
                    ],
                    'golden_glow' => [
                        'bg' => 'linear-gradient(135deg, #78350f 0%, #451a03 100%)',
                        'header_color' => '#fef08a', 'occasion_color' => '#ffffff', 'footer_bg' => 'rgba(255,255,255,0.15)', 'icon' => '🍛✨'
                    ],
                    'minimal_clean' => [
                        'bg' => 'linear-gradient(135deg, #064e3b 0%, #022c22 100%)',
                        'header_color' => '#f0fdf4', 'occasion_color' => '#a7f3d0', 'footer_bg' => 'rgba(255,255,255,0.08)', 'icon' => '🥐☕'
                    ]
                ];

                $active = $themes[$currentTheme] ?? $themes['dark_slate'];

                $fontFamilies = [
                    'modern_sans' => "Arial, sans-serif",
                    'classic_serif' => "Georgia, serif",
                    'luxury_display' => "'Times New Roman', serif",
                    'playful_rounded' => "'Trebuchet MS', sans-serif",
                ];
                $fontFamily = $fontFamilies[$status->font_style ?? 'classic_serif'] ?? $fontFamilies['classic_serif'];
                $fontSize = min(42, max(16, (int) ($status->font_size ?? 24)));
                $flyerBackground = $status->custom_template_path
                    ? "linear-gradient(rgba(2, 6, 23, 0.18), rgba(2, 6, 23, 0.3)), url('" . asset($status->custom_template_path) . "')"
                    : $active['bg'];
                
                // Extract clean display title for the flyer canvas text overlay
                $flyerHeadingText = $status->background_template_path;
                if(empty($flyerHeadingText) || str_contains($flyerHeadingText, 'public') || strlen($flyerHeadingText) > 25) {
                    $flyerHeadingText = "SUNDAY SPECIAL OFFER";
                }
            ?>

            <!-- HIGH-PERFORMANCE DYNAMIC HTML LIVE FLYER -->
            <div class="live-flyer" id="statusFlyer" style="background: <?php echo e($flyerBackground); ?>; background-size: cover; background-position: center;">
                <?php if($status->custom_template_path): ?>
                    <img class="custom-template-image" src="<?php echo e(asset($status->custom_template_path)); ?>" alt="Uploaded flyer template">
                <?php endif; ?>
                <div>
                    <div style="font-family: <?php echo e($fontFamily); ?>; font-size: <?php echo e($fontSize); ?>px; font-weight: 900; color: <?php echo e($active['header_color']); ?>; text-shadow: 0 2px 4px rgba(0,0,0,0.4);">
                        <?php echo e(strtoupper($shop->shop_name)); ?>

                    </div>
                    <div style="font-family: <?php echo e($fontFamily); ?>; font-size: <?php echo e(max(12, $fontSize - 8)); ?>px; font-weight: 800; color: <?php echo e($active['occasion_color']); ?>; margin-top: 6px; text-transform: uppercase; letter-spacing: 0.5px;">
                        <?php echo e(strtoupper($flyerHeadingText)); ?>

                    </div>
                </div>
                
                <!-- Native UI Center Graphic Icon Visual Box -->
                <div style="width: 95%; aspect-ratio: 4/3; background-color: rgba(255,255,255,0.04); border: 2px dashed rgba(255,255,255,0.1); margin: auto; border-radius: 15px; display: flex; align-items: center; justify-content: center; font-size: 54px; filter: drop-shadow(0 5px 10px rgba(0,0,0,0.3));">
                    <?php echo e($active['icon']); ?>

                </div>
                
                <div style="font-family: <?php echo e($fontFamily); ?>; font-size: <?php echo e(max(12, $fontSize - 10)); ?>px; font-weight: 700; color: #ffffff; background-color: <?php echo e($active['footer_bg']); ?>; padding: 8px 15px; border-radius: 30px; display: inline-block; margin: 0 auto;">
                    📞 WhatsApp to Order: <?php echo e($shop->whatsapp_number); ?>

                </div>
            </div>

            <!-- 💾 DYNAMIC EDIT & UPDATE SUBMISSION FORM -->
            <form action="<?php echo e(route('status.save.refresh', $status->id)); ?>" method="POST" style="width: 100%; margin-bottom: 12px;">
                <?php echo csrf_field(); ?>
                <div class="caption-title">Today's Status Caption (Tap to Edit)</div>
                <div class="caption-box">
                    <textarea name="generated_text" id="captionText" required placeholder="Type custom offer info here..." style="font-family: <?php echo e($fontFamily); ?>; font-size: <?php echo e(min(24, max(16, $fontSize))); ?>px;"><?php echo e(trim($status->generated_text)); ?></textarea>
                </div>

                <button type="submit" style="width: 100%; background-color: #6366f1; color: white; border: none; font-size: 14px; font-weight: 700; padding: 12px; border-radius: 14px; cursor: pointer; box-shadow: 0 4px 6px rgba(99, 102, 241, 0.15); transition: all 0.2s;">
                    💾 Save Changes & Update Flyer Text
                </button>
                <!-- 📥 NATIVE IMAGE DOWNLOAD CTA (Converts HTML flyer to an actual image file) -->
            <button type="button" onclick="downloadFlyerImage(this)" style="width: 100%; background-color: #3b82f6; color: white; border: none; font-size: 14px; font-weight: 700; padding: 14px; border-radius: 14px; cursor: pointer; display: flex; align-items: center; justify-content: center; gap: 8px; box-shadow: 0 4px 6px -1px rgba(59, 130, 246, 0.2); margin-bottom: 12px;">
    📥 Download Flyer Image
</button>

            </form>

            <!-- 🟢 Primary Copy & WhatsApp Trigger CTA -->
            <button onclick="postToWhatsApp()" class="whatsapp-btn" style="margin-bottom: 15px;">
                Copy Caption & Open WhatsApp
            </button>

            <!-- ⚡ Background Force Regeneration Core Controller Route Form -->
            <form action="<?php echo e(route('shop.generate.test', $shop->id)); ?>" method="GET" style="width: 100%; margin-top: auto;">
               <input type="hidden" name="occasion" value="Sunday special offer">
                <button type="submit" class="force-btn">
                    ⚡ Force Re-Generate via Gemini API
                </button>
            </form>
        <?php else: ?>
            <div class="empty-state">
                <p style="margin-bottom: 20px; color:#64748b;">Today's marketing content hasn't been generated yet.</p>
                <form action="<?php echo e(route('shop.generate.test', $shop->id)); ?>" method="GET">
                    <input type="hidden" name="occasion" value="Sunday special offer">
                    <button type="submit" class="force-btn" style="background-color:#4f46e5; padding: 14px; font-size:14px;">
                        ⚡ Generate Today's Status
                    </button>
                </form>
            </div>
        <?php endif; ?>
    </div>

    <script>
    function postToWhatsApp() {
        const textToCopy = document.getElementById('captionText').value;

        if (navigator.clipboard && navigator.clipboard.writeText) {
            navigator.clipboard.writeText(textToCopy).then(() => { executeDeepLink(); });
        } else {
            const textArea = document.createElement("textarea");
            textArea.value = textToCopy;
            textArea.style.position = "fixed"; textArea.style.opacity = "0";
            document.body.appendChild(textArea); textArea.focus(); textArea.select();
            document.execCommand('copy'); document.body.removeChild(textArea);
            executeDeepLink();
        }
    }

    function executeDeepLink() {
    alert(
        "📋 TEXT CAPTION COPIED TO CLIPBOARD!\n\n" +
        "What to do on the next screen:\n\n" +
        "1️⃣ In WhatsApp, select 'My Status'.\n" +
        "2️⃣ Pick the flyer image you just downloaded (it will be the first image in your gallery).\n" +
        "3️⃣ Long-press the text caption box, tap PASTE, and share!"
    );
    
    setTimeout(function() {
        window.location.href = "whatsapp://status";
    }, 300);
}
    async function downloadFlyerImage(btn) {
        const flyer = document.getElementById("statusFlyer");
        const originalText = btn.innerHTML;
        btn.innerHTML = "⏳ Saving to Gallery...";
        btn.style.opacity = "0.7";
        btn.disabled = true;

        try {
            if (typeof html2canvas !== "function") {
                throw new Error("Flyer capture library is unavailable.");
            }

            const canvas = await html2canvas(flyer, {
                backgroundColor: null,
                scale: 2,
                useCORS: true,
                logging: false,
                width: flyer.offsetWidth,
                height: flyer.offsetHeight,
            });

            const link = document.createElement("a");
            link.download = "Flyer_Status_" + Date.now() + ".jpg";
            link.href = canvas.toDataURL("image/jpeg", 0.95);
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);
        } catch (error) {
            console.error("Flyer capture failed:", error);
            alert("The flyer could not be saved right now. Please take a screenshot of the preview instead.");
        } finally {
            btn.innerHTML = originalText;
            btn.style.opacity = "1";
            btn.disabled = false;
        }
    }


    </script>

</body>
</html>
<?php /**PATH D:\laravelai\resources\views\status\review.blade.php ENDPATH**/ ?>