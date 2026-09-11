<?php

namespace Tests\Feature;

use Tests\TestCase;

class VercelDeploymentConfigTest extends TestCase
{
    public function test_vercel_entrypoint_for_laravel_application_exists(): void
    {
        $vercel = json_decode(file_get_contents(base_path('vercel.json')), true);

        $this->assertIsArray($vercel);
        $this->assertArrayHasKey('functions', $vercel);
        $this->assertArrayHasKey('api/index.php', $vercel['functions']);
        $this->assertSame('vercel-php@0.3.1', $vercel['functions']['api/index.php']['runtime']);
        $this->assertFileExists(base_path('api/index.php'));
    }
}
