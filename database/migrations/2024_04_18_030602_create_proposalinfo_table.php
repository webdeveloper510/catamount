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
        Schema::create('proposalinfo', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('lead_id');
            $table->foreign('lead_id')->references('id')->on('leads');
            $table->string('email')->nullable();
            $table->text('subject')->nullable();
            $table->text('content')->nullable();
            $table->text('proposal_info')->nullable();
            $table->string('attachments')->nullable();
            $table->integer('created_by')->nullable();
            $table->string('proposal_mode')->nullable()->default('email');
            $table->longText('proposal_data')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('proposalinfo');
    }
};
