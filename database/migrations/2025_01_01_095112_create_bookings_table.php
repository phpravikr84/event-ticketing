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
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Foreign key for user_id
            $table->json('details'); // Store cart details in JSON format
            $table->string('payment_method'); // Payment method (e.g., 'virtual')
            $table->tinyInteger('status')->default(1); // Status as integer (1 = Pending, 2 = Complete, 3 = Cancelled, 4 = Failed)
            $table->timestamps(); // Created and updated timestamps
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
