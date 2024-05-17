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
        Schema::create('master_customers', function (Blueprint $table) {
            $table->id();
            $table->integer('ref_id');
            $table->string('name');
            $table->string('email');
            $table->text('address')->nullable();
            $table->integer('phone');
            $table->string('category')->nullable();
            $table->string('type');
            $table->timestamps();
            $table->softDeletes();         
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('master_customers');
    }
};
