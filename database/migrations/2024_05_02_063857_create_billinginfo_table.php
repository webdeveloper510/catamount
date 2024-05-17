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
        Schema::create('billinginfo', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('event_id');
            $table->foreign('event_id')->references('id')->on('meetings');
            $table->float('bill_amount');
            $table->float('deposits');
            $table->float('adjustments');
            $table->float('latefee');
            $table->float('other');
            $table->float('collect_amount');
            $table->string('paymentref')->nullable();
            $table->string('modeofpayment')->nullable();
            $table->string('notes')->nullable();
            $table->timestamps();
            $table->softDeletes(); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('billinginfo');
    }
};
