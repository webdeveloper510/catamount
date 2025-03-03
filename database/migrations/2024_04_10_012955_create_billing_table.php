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
        Schema::create('billing', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('event_id')->unique();
            $table->foreign('event_id')->references('id')->on('meetings');
            $table->int('invoiceID')->default(0)->nullable();
            $table->text('data');
            $table->float('deposits')->default(0)->nullable();
            $table->float('salesTax')->default(0)->nullable();
            $table->float('totalAmount')->default(0)->nullable();
            $table->float('paymentCredit')->default(0)->nullable();
            $table->int('purchaseOrder')->default(0)->nullable();
            $table->text('terms')->default(0)->nullable();
            $table->boolean('status')->default(0);
            $table->integer('created_by')->default(0);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('billing');
    }
};
