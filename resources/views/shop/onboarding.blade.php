<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shop Setup Onboarding</title>
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Arial, sans-serif; }
        body { background-color: #0f172a; display: flex; align-items: center; justify-content: center; min-height: 100vh; padding: 15px; }
        .form-container { width: 100%; max-width: 450px; background-color: #f8fafc; border-radius: 30px; box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5); padding: 25px; border: 1px solid #e2e8f0; }
        h2 { font-size: 22px; font-weight: 800; color: #1e293b; margin-bottom: 5px; tracking-tight: -0.5px; }
        p { font-size: 13px; color: #64748b; margin-bottom: 20px; line-height: 1.4; }
        .form-group { margin-bottom: 15px; }
        label { display: block; font-size: 12px; font-weight: 700; color: #475569; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 5px; }
        input, textarea, select { width: 100%; padding: 12px 15px; font-size: 14px; border-radius: 12px; border: 1px solid #cbd5e1; background-color: white; outline: none; color: #334155; }
        input:focus, textarea:focus, select:focus { border-color: #4f46e5; box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.1); }
        textarea { resize: none; min-height: 70px; }
        .submit-btn { width: 100%; background: linear-gradient(135deg, #4f46e5 0%, #4338ca 100%); color: white; border: none; font-size: 15px; font-weight: 800; padding: 15px; border-radius: 14px; cursor: pointer; box-shadow: 0 10px 15px rgba(79, 70, 229, 0.2); margin-top: 10px; }
        .submit-btn:active { transform: scale(0.98); }
        .microphone { margin-left: 8px; padding: 10px 12px; border-radius: 10px; background: #e0f2fe; color: #075985; border: 1px solid #7dd3fc; font-size: 12px; font-weight: 800; cursor: pointer; white-space: nowrap; }
        .voice-row { display: flex; align-items: center; gap: 8px; }
    </style>
</head>
<body>

    <div class="form-container">
        <h2>Setup Your Business</h2>
        <p>Enter your information once to get personalized, ready-to-post daily WhatsApp Status updates instantly. You can type in Hindi or English, or speak and record the shop details.</p>

        <form action="{{ route('shop.store') }}" method="POST">
            @csrf

            <div class="form-group">
                <label>Language You Will Use</label>
                <select name="source_language" required>
                    <option value="en">English</option>
                    <option value="hi">Hindi</option>
                </select>
            </div>

            <div class="form-group">
                <label>How Will You Enter Details?</label>
                <select name="input_method" required>
                    <option value="text">Type it</option>
                    <option value="voice">Voice input</option>
                </select>
            </div>
            
            <div class="form-group">
                <label>Shop Name</label>
                <div class="voice-row">
                    <input type="text" name="shop_name" placeholder="e.g., The Pizza Corner / पिज़्ज़ा कोर्नर" required>
                    <button type="button" class="microphone" data-target="shop_name">🎙️</button>
                </div>
            </div>

            <div class="form-group">
                <label>Business Category</label>
                <div class="voice-row">
                    <input type="text" name="category" placeholder="e.g., Fast Food Cafe / फास्ट फूड कैफे" required>
                    <button type="button" class="microphone" data-target="category">🎙️</button>
                </div>
            </div>

            <div class="form-group">
                <label>Star Products / Services</label>
                <div class="voice-row">
                    <textarea name="products_services" placeholder="e.g., Cheese Pizza, Garlic Bread, Mango Shakes / पिज़्ज़ा, ब्रेड, स्मूथी" required></textarea>
                    <button type="button" class="microphone" data-target="products_services">🎙️</button>
                </div>
            </div>

            <div class="form-group">
                <label>WhatsApp Business Number</label>
                <input type="text" name="whatsapp_number" placeholder="e.g., +919876543210" required>
            </div>

            <div class="form-group">
                <label>Shop Location / Area</label>
                <div class="voice-row">
                    <input type="text" name="location" placeholder="e.g., Sector 62, Noida / सेक्टर 62, नोएडा" required>
                    <button type="button" class="microphone" data-target="location">🎙️</button>
                </div>
            </div>

            <div class="form-group">
                <label>Brand Style Vibe</label>
                <select name="brand_style" required>
                    <option value="energetic and fun">Energetic & Fun</option>
                    <option value="premium and royal">Premium & Royal</option>
                    <option value="traditional and welcoming">Traditional & Welcoming</option>
                    <option value="minimalist and clean">Minimalist & Clean</option>
                </select>
            </div>

            <button type="submit" class="submit-btn">✨ Build My Marketing Hub</button>
        </form>
    </div>

    <script>
        const voiceButtons = document.querySelectorAll('.microphone');
        voiceButtons.forEach((button) => {
            button.addEventListener('click', function () {
                const targetName = this.getAttribute('data-target');
                const target = document.getElementsByName(targetName)[0];

                if (!('webkitSpeechRecognition' in window) && !('SpeechRecognition' in window)) {
                    target.placeholder = 'Voice input is not supported in this browser';
                    return;
                }

                const SpeechRecognition = window.SpeechRecognition || window.webkitSpeechRecognition;
                const recognition = new SpeechRecognition();
                recognition.lang = document.getElementsByName('source_language')[0].value === 'hi' ? 'hi-IN' : 'en-US';
                recognition.interimResults = false;
                recognition.maxAlternatives = 1;

                recognition.onresult = function (event) {
                    const transcript = event.results[0][0].transcript;
                    target.value = (target.value ? target.value + ' ' : '') + transcript;
                };

                recognition.onerror = function () {
                    target.placeholder = 'Please try again';
                };

                recognition.start();
            });
        });
    </script>
</body>
</html>
