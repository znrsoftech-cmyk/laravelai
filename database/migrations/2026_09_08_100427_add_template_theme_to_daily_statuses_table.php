<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('daily_statuses', function (Blueprint $table) {
        // Default theme can be your current dark-slate layout
            $table->string('template_theme')->default('dark_slate')->after('background_template_path');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('daily_statuses', function (Blueprint $table) {
            $table->dropColumn('template_theme');
        });
    }
};
