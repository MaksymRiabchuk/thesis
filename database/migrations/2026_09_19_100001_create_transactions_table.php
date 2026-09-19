<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('rental_id')->constrained()->restrictOnDelete();
            $table->foreignId('user_id')->constrained()->restrictOnDelete();
            $table->string('type');
            $table->string('status')->default('pending');
            $table->decimal('amount', 10, 2);
            $table->char('currency', 3)->default('USD');
            $table->string('provider')->nullable();
            $table->string('provider_transaction_id')->nullable()->unique();
            $table->json('provider_payload')->nullable();
            $table->string('failure_reason')->nullable();
            $table->timestamp('paid_at')->nullable();
            $table->timestamps();

            $table->index(['type', 'status', 'paid_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
