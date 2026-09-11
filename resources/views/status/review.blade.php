<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daily Status Hub</title>
    <script src="https://cdn.jsdelivr.net/npm/html2canvas@1.4.1/dist/html2canvas.min.js"></script>
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; font-family: "Inter", "Segoe UI", Roboto, Arial, sans-serif; }

        body {
            background: #edf4f8;
            color: #243447;
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            padding: 12px;
        }

        .phone-container {
            width: min(420px, 100%);
            min-height: 860px;
            background: #ffffff;
            border: 1px solid #d9e3ee;
            border-radius: 24px;
            box-shadow: 0 16px 40px rgba(30, 41, 59, 0.12);
            display: flex;
            flex-direction: column;
            padding: 22px;
            overflow: hidden;
            position: relative;
        }

        header {
            border-bottom: 1px solid #e5eef4;
            padding-bottom: 14px;
            margin-bottom: 16px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 12px;
        }

        h1 {
            font-size: 22px;
            font-weight: 800;
            color: #1e293b;
            letter-spacing: -0.4px;
            margin: 0;
        }

        .tag {
            font-size: 11px;
            font-weight: 800;
            color: #005a4c;
            background: #d8f8eb;
            padding: 4px 10px;
            border-radius: 99px;
            margin-top: 6px;
            display: inline-block;
            text-transform: uppercase;
            letter-spacing: 0.4px;
        }

        .dashboard-controls {
            display: flex;
            flex-direction: column;
            align-items: flex-end;
            gap: 8px;
            min-width: 190px;
        }

        .theme-select,
        .control-select {
            min-height: 34px;
            border: 1px solid #b8c7d9;
            border-radius: 10px;
            padding: 6px 10px;
            font-size: 11px;
            font-weight: 700;
            color: #334155;
            background: #ffffff;
            cursor: pointer;
        }

        .theme-select {
            color: #4053c8;
            background: #eef4ff;
        }

        .typography-controls,
        .template-upload {
            display: flex;
            align-items: center;
            gap: 6px;
            justify-content: flex-end;
            flex-wrap: wrap;
        }

        .typography-controls .control-select,
        .typography-controls .typography-submit,
        .template-upload button {
            min-height: 30px;
            border-radius: 8px;
        }

        .typography-submit {
            border: none;
            background: #4053c8;
            color: #fff;
            font-size: 11px;
            font-weight: 800;
            padding: 7px 11px;
            cursor: pointer;
        }

        .template-upload {
            color: #475569;
            font-size: 10px;
        }

        .template-upload label {
            font-weight: 700;
            color: #475569;
        }

        .template-upload input[type="file"] {
            max-width: 150px;
            font-size: 10px;
            color: #41546b;
        }

        .template-upload button {
            border: none;
            background: #0ea5e9;
            color: #fff;
            font-weight: 800;
            padding: 7px 11px;
            cursor: pointer;
        }

        .live-flyer {
            width: 100%;
            max-height: 480px;
            aspect-ratio: 9 / 11;
            border-radius: 20px;
            border: 2px solid #eef2f7;
            box-shadow: 0 12px 24px rgba(0,0,0,0.12);
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            padding: 24px 20px;
            text-align: center;
            margin-bottom: 16px;
            position: relative;
            overflow: hidden;
            color: #fff;
        }

        .live-flyer > div {
            position: relative;
            z-index: 1;
        }

        .custom-template-image {
            position: absolute;
            inset: 0;
            z-index: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            object-position: center;
        }

        .caption-title {
            font-size: 11px;
            font-weight: 800;
            color: #64748b;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 8px;
        }

        .caption-box {
            background: #eef5f8;
            border: 1px solid #d5edf2;
            border-radius: 16px;
            padding: 14px;
            min-height: 110px;
            display: flex;
            margin-bottom: 12px;
            box-shadow: inset 0 0 0 1px rgba(255,255,255,0.8);
        }

        #captionText {
            width: 100%;
            border: none;
            outline: none;
            background: transparent;
            color: #334155;
            font-weight: 600;
            resize: none;
            line-height: 1.45;
        }

        .btn-save,
        .btn-download,
        .whatsapp-btn,
        .force-btn {
            width: 100%;
            border-radius: 12px;
            font-weight: 800;
            font-size: 13px;
            padding: 12px;
            cursor: pointer;
        }

        .btn-save {
            background: #4053c8;
            color: #ffffff;
            border: none;
            margin-bottom: 10px;
        }

        .btn-download {
            background: #0ea5e9;
            color: #ffffff;
            border: none;
            margin-bottom: 10px;
        }

        .whatsapp-btn {
            background: #10b981;
            color: #fff;
            border: none;
            margin: 12px 0;
        }

        .force-btn {
            background: transparent;
            color: #64748b;
            border: none;
            text-transform: uppercase;
            letter-spacing: 0.2px;
            margin-top: 8px;
        }

        @media (max-width: 420px) {
            body { padding: 6px; }
            .phone-container { min-height: calc(100vh - 12px); padding: 16px; border-radius: 28px; }
            header { align-items: flex-start; }
            .dashboard-controls { min-width: 145px; }
            .template-upload input[type="file"] { width: 130px; }
        }
    </style>

</head>
<body>

    <div class="phone-container">
        
        <!-- Status Notification Popup Banner Alerts -->
        @if(session('success'))
            <div style="margin-bottom: 12px; padding: 10px 15px; background-color: #10b981; color: white; font-size: 12px; font-weight: 700; border-radius: 10px; box-shadow: 0 4px 6px rgba(0,0,0,0.05);">
                ✨ {{ session('success') }}
            </div>
        @endif
        @if(session('error'))
            <div style="margin-bottom: 12px; padding: 10px 15px; background-color: #ef4444; color: white; font-size: 12px; font-weight: 700; border-radius: 10px;">
                ❌ {{ session('error') }}
            </div>
        @endif

        <!-- Shop and flyer controls -->
        <header>
            <div>
                <h1>{{ $shop->shop_name }}</h1>
                <div class="tag">{{ $shop->category }}</div>
            </div>
            @if($status)
                <div class="dashboard-controls">
                    <form action="{{ route('status.update.theme', $status->id) }}" method="POST" id="themeForm">
                        @csrf
                        <select class="theme-select" name="template_theme" onchange="document.getElementById('themeForm').submit()" aria-label="Choose flyer style">
                            <option value="dark_slate" {{ $status->template_theme == 'dark_slate' ? 'selected' : '' }}>Style: Midnight</option>
                            <option value="spicy_red" {{ $status->template_theme == 'spicy_red' ? 'selected' : '' }}>Style: Red</option>
                            <option value="golden_glow" {{ $status->template_theme == 'golden_glow' ? 'selected' : '' }}>Style: Gold</option>
                            <option value="minimal_clean" {{ $status->template_theme == 'minimal_clean' ? 'selected' : '' }}>Style: Mint</option>
                            <option value="ocean_blue" {{ $status->template_theme == 'ocean_blue' ? 'selected' : '' }}>Style: Blue</option>
                            <option value="royal_plum" {{ $status->template_theme == 'royal_plum' ? 'selected' : '' }}>Style: Plum</option>
                        </select>
                    </form>

                    <form class="typography-controls" action="{{ route('status.update.typography', $status->id) }}" method="POST" id="typographyForm">
                        @csrf
                        <select class="control-select" name="font_style" aria-label="Font style">
                            <option value="modern_sans" {{ ($status->font_style ?? 'classic_serif') === 'modern_sans' ? 'selected' : '' }}>Sans</option>
                            <option value="classic_serif" {{ ($status->font_style ?? 'classic_serif') === 'classic_serif' ? 'selected' : '' }}>Serif</option>
                            <option value="luxury_display" {{ ($status->font_style ?? 'classic_serif') === 'luxury_display' ? 'selected' : '' }}>Display</option>
                            <option value="playful_rounded" {{ ($status->font_style ?? 'classic_serif') === 'playful_rounded' ? 'selected' : '' }}>Rounded</option>
                        </select>
                        <select class="control-select" name="font_size" aria-label="Font size">
                            @foreach([16, 20, 24, 28, 32, 36, 40] as $fontSize)
                                <option value="{{ $fontSize }}" {{ (int) ($status->font_size ?? 24) === $fontSize ? 'selected' : '' }}>{{ $fontSize }}px</option>
                            @endforeach
                        </select>
                        <button class="typography-submit" type="submit" aria-label="Apply typography">Apply</button>
                    </form>

                    <form class="template-upload" action="{{ route('status.upload.template', $status->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <label for="templateImage">Add photo</label>
                        <input id="templateImage" type="file" name="template_image" accept="image/jpeg,image/png,image/webp" required>
                        <button type="submit">Upload</button>
                    </form>
                </div>
            @else
                <span class="badge" style="background-color: #e2e8f0; color: #64748b;">No flyer yet</span>
            @endif
        </header>

        @if($status)
            @php
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
                    ],
                    'ocean_blue' => [
                        'bg' => 'linear-gradient(135deg, #0f766e 0%, #082f49 100%)',
                        'header_color' => '#e0f2fe', 'occasion_color' => '#a7f3d0', 'footer_bg' => 'rgba(255,255,255,0.08)', 'icon' => '🌊🥗'
                    ],
                    'royal_plum' => [
                        'bg' => 'linear-gradient(135deg, #4c1d95 0%, #2e1065 100%)',
                        'header_color' => '#f5d0fe', 'occasion_color' => '#f8fafc', 'footer_bg' => 'rgba(255,255,255,0.08)', 'icon' => '🍽️👑'
                    ],
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
            @endphp

            <!-- HIGH-PERFORMANCE DYNAMIC HTML LIVE FLYER -->
            <div class="live-flyer" id="statusFlyer" style="background: {{ $flyerBackground }}; background-size: cover; background-position: center;">
                @if($status->custom_template_path)
                    <img class="custom-template-image" src="{{ asset($status->custom_template_path) }}" alt="Uploaded flyer template">
                @endif
                <div>
                    <div style="font-family: {{ $fontFamily }}; font-size: {{ $fontSize }}px; font-weight: 900; color: {{ $active['header_color'] }}; text-shadow: 0 2px 4px rgba(0,0,0,0.4);">
                        {{ strtoupper($shop->shop_name) }}
                    </div>
                    <div style="font-family: {{ $fontFamily }}; font-size: {{ max(12, $fontSize - 8) }}px; font-weight: 800; color: {{ $active['occasion_color'] }}; margin-top: 6px; text-transform: uppercase; letter-spacing: 0.5px;">
                        {{ strtoupper($flyerHeadingText) }}
                    </div>
                </div>
                
                <!-- Native UI Center Graphic Icon Visual Box -->
                <div style="width: 95%; aspect-ratio: 4/3; background-color: rgba(255,255,255,0.04); border: 2px dashed rgba(255,255,255,0.1); margin: auto; border-radius: 15px; display: flex; align-items: center; justify-content: center; font-size: 54px; filter: drop-shadow(0 5px 10px rgba(0,0,0,0.3));">
                    {{ $active['icon'] }}
                </div>
                
                <div style="font-family: {{ $fontFamily }}; font-size: {{ max(12, $fontSize - 10) }}px; font-weight: 700; color: #ffffff; background-color: {{ $active['footer_bg'] }}; padding: 8px 15px; border-radius: 30px; display: inline-block; margin: 0 auto;">
                    📞 WhatsApp to Order: {{ $shop->whatsapp_number }}
                </div>
            </div>

            <!-- Main editor area -->
            <form action="{{ route('status.save.refresh', $status->id) }}" method="POST" style="width: 100%; margin-bottom: 12px;">
                @csrf
                <div class="caption-title">Today’s offer text</div>
                <div class="caption-box">
                    <textarea name="generated_text" id="captionText" required placeholder="Type your offer message here..." style="font-family: {{ $fontFamily }}; font-size: {{ min(24, max(16, $fontSize)) }}px;">{{ trim($status->generated_text) }}</textarea>
                </div>

                <button type="submit" class="btn-save">
                    💾 Save flyer text
                </button>

                <button type="button" class="btn-download" onclick="downloadFlyerImage(this)">
                    📥 Download flyer image
                </button>
            </form>

            <button onclick="postToWhatsApp()" class="whatsapp-btn">
                📲 Copy text and open WhatsApp
            </button>

            <form action="{{ route('shop.generate.test', $shop->id) }}" method="GET" style="width: 100%; margin-top: auto;">
                <input type="hidden" name="occasion" value="Sunday special offer">
                <button type="submit" class="force-btn">
                    ⚡ Make a new flyer
                </button>
            </form>
        @else
            <div class="empty-state">
                <p style="margin-bottom: 20px; color:#64748b;">Today's marketing content hasn't been generated yet.</p>
                <form action="{{ route('shop.generate.test', $shop->id) }}" method="GET">
                    <input type="hidden" name="occasion" value="Sunday special offer">
                    <button type="submit" class="force-btn" style="background-color:#4f46e5; padding: 14px; font-size:14px;">
                        ⚡ Generate Today's Status
                    </button>
                    
                </form>
            </div>
        @endif
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
