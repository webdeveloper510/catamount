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
        Schema::create('proposal', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('lead_id');
            $table->foreign('lead_id')->references('id')->on('leads');
            $table->integer('proposal_id');
            $table->string('image')->nullable();
            $table->string('notes')->nullable();
            $table->text('agreement')->nullable();
            $table->text('remarks')->nullable();
            $table->string('name')->nullable();
            $table->string('designation')->nullable();
            $table->date('date')->nullable();
            $table->string('to_name')->nullable();
            $table->string('to_designation')->nullable();
            $table->date('to_date')->nullable();
            $table->string('proposal_response')->nullable();
            $table->timestamps();
            $table->SoftDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('proposal');
    }
};
