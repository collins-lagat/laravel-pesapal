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
        Schema::create('pesapal_checkouts', function (Blueprint $table) {
            $table->id();
            $table->string('order_tracking_id');
            $table->string('order_merchant_type')->nullable();
            $table->string('order_merchant_reference');
            $table->enum('state', ['pending', 'completed', 'invalid', 'failed', 'reversed'])->default('pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pesapal_checkouts');
    }
};
