<?php

namespace Tests\Feature;

use App\Http\Controllers\ChatController;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class ChatButtonsTest extends TestCase
{
    public function test_save_refresh_route_points_to_an_available_controller_action(): void
    {
        $route = app('router')->getRoutes()->getByName('status.save.refresh');

        $this->assertSame(
            'App\\Http\\Controllers\\StatusDashboardController@saveAndRefresh',
            $route->getActionName()
        );
    }

    public function test_shop_onboarding_alias_redirects_to_the_onboarding_page(): void
    {
        $response = $this->get('/shop/onboarding');

        $response->assertRedirectToRoute('shop.onboarding');
    }

    public function test_chat_page_has_new_chat_and_all_chats_buttons(): void
    {
        $response = $this->get('/chat');

        $response->assertOk();
        $response->assertSee('New Chat');
        $response->assertSee('All Chats');
    }

    public function test_shop_dashboard_review_template_uses_simple_clear_labels_for_non_technical_users(): void
    {
        $view = file_get_contents(base_path('resources/views/status/review.blade.php'));

        $this->assertStringContainsString("Today’s offer text", $view);
        $this->assertStringContainsString("Save flyer text", $view);
        $this->assertStringContainsString("Download flyer image", $view);
        $this->assertStringContainsString("Copy text and open WhatsApp", $view);
        $this->assertStringContainsString("Make a new flyer", $view);
    }

    public function test_new_chat_forces_a_fresh_conversation_without_reusing_previous_db_history(): void
    {
        DB::statement('CREATE TABLE agent_conversations (id TEXT PRIMARY KEY, user_id INTEGER, title TEXT, created_at TEXT, updated_at TEXT)');
        DB::table('agent_conversations')->insert([
            'id' => 'conv-old-1',
            'user_id' => 99,
            'title' => 'Previous chat',
            'created_at' => now()->toDateTimeString(),
            'updated_at' => now()->toDateTimeString(),
        ]);

        session()->put('product_agent_force_new', true);

        $controller = new ChatController();
        $method = new \ReflectionMethod($controller, 'resolveConversation');
        $method->setAccessible(true);

        $user = new class {
            public $id = 99;
        };

        $this->assertNull($method->invoke($controller, $user));
    }
}
