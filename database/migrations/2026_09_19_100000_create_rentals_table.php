<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('rentals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('offer_id')->constrained()->restrictOnDelete();
            $table->foreignId('renter_id')->constrained('users')->restrictOnDelete();
            $table->foreignId('owner_id')->constrained('users')->restrictOnDelete();
            $table->dateTime('starts_at');
            $table->dateTime('ends_at');
            $table->unsignedSmallInteger('days');
            $table->unsignedInteger('quantity')->default(1);
            $table->decimal('price_per_day', 10, 2);
            $table->decimal('total_amount', 10, 2);
            $table->char('currency', 3)->default('USD');
            $table->string('status')->default('confirmed');
            $table->timestamp('cancelled_at')->nullable();
            $table->string('cancel_reason')->nullable();
            $table->timestamps();

            $table->index(['offer_id', 'starts_at', 'ends_at']);
            $table->index(['owner_id', 'status']);
            $table->index('renter_id');
            $table->index('created_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('rentals');
    }
};
