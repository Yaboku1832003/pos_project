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
        Schema::create('payment_histories', function (Blueprint $table) {
            $table->id();
            $table->string('user_name');        // User's name
            $table->string('phone');            // Phone number
            $table->text('address');            // Address
            $table->string('payment_voucher');  // Uploaded voucher filename
            $table->string('payment_type');     // Payment method type (or you can use foreign key)
            $table->string('order_code');       // Order code
            $table->decimal('final_total', 15, 2); // Final total amount
            $table->timestamps();
});


    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payment_histories');
    }
};
