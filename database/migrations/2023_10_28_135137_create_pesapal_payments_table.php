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
        Schema::create('pesapal_payments', function (Blueprint $table) {
            $table->id();
            $table->string('order_tracking_id');
            $table->string('merchant_reference');
            $table->string('payment_method')->nullable();
            $table->decimal('transaction_amount', 10, 2)->nullable();
            $table->string('confirmation_code')->nullable();
            $table->enum('payment_status_description', ['pending', 'failed', 'completed', 'invalid', 'reversed'])->default('pending');
            $table->string('description')->nullable();
            $table->string('message')->nullable();
            $table->string('payment_account')->nullable();
            $table->string('call_back_url')->nullable();
            $table->tinyInteger('status_code')->nullable();
            $table->string('payment_status_code')->nullable();
            $table->string('currency')->nullable();
            $table->json('error')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pesapal_payments');
    }
};
