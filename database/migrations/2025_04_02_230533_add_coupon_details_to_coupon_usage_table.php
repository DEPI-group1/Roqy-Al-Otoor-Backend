<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('coupon_usage', function (Blueprint $table) {
            $table->decimal('original_price', 10, 2);
            $table->decimal('discount_value', 10, 2);
            $table->decimal('final_price', 10, 2);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('coupon_usage', function (Blueprint $table) {
            //
        });
    }
};