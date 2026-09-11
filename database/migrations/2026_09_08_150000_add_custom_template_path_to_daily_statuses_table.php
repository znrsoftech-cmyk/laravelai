<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('daily_statuses', function (Blueprint $table) {
            $table->string('custom_template_path')->nullable()->after('background_template_path');
        });
    }

    public function down(): void
    {
        Schema::table('daily_statuses', function (Blueprint $table) {
            $table->dropColumn('custom_template_path');
        });
    }
};