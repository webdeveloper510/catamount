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
        Schema::create('payment_info', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('event_id');
            $table->foreign('event_id')->references('id')->on('meetings');
            $table->float('amount');
            $table->float('deposits');
            $table->float('adjustments');
            $table->float('latefee');
            $table->float('amounttobepaid');
            $table->string('adjustmentnotes')->nullable();
            $table->string('paymentref')->nullable();
            $table->string('modeofpayment')->nullable();
            $table->string('notes')->nullable();
            $table->date('date');
            $table->timestamps();
            $table->softDeletes(); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payment_info');
    }
};
 