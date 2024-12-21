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
         Schema::create('orders', function (Blueprint $table) {
             $table->id();
             $table->unsignedBigInteger('customer_id');
             $table->decimal('total_price', 10, 2);
             $table->string('order_number')->unique();
             $table->string('status')->default('Pending');
             $table->unsignedBigInteger('driver_id')->nullable(); // Explicitly declare type
             $table->timestamps();
     
             // Add the foreign key constraints
             $table->foreign('customer_id')->references('id')->on('customers')->onDelete('cascade');
             $table->foreign('driver_id')->references('id')->on('drivers')->onDelete('set null');
         });
     }
     


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
