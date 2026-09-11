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
            $table->string('font_style')->default('classic_serif')->after('template_theme');
            $table->integer('font_size')->default(24)->after('font_style');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('daily_statuses', function (Blueprint $table) {
            $table->dropColumn(['font_style', 'font_size']);
        });
    }
};
