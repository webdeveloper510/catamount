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
        Schema::create('leads', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id')->default(0);
            $table->string('leadname')->nullable();
            $table->string('name')->nullable();
            $table->string('email');
            $table->string('phone')->nullable();
            $table->string('company_name')->nullable();
            $table->string('relationship')->nullable();
            $table->integer('guest_count')->default(0);
            $table->string('function')->nullable();
            $table->string('type')->nullable();
            $table->string('venue_selection')->nullable();
            $table->date('start_date');
            $table->integer('proposal_status')->default(0);
            $table->integer('status')->default(0);
            $table->integer('lead_status')->default(0);
            $table->date('end_date');
            $table->string('func_package')->nullable();
            $table->string('bar_package')->nullable();
            $table->text('lead_address')->nullable();
            $table->string('description')->nullable();
            $table->string('spcl_req')->nullable();
            $table->string('allergies')->nullable();
            $table->integer('assigned_user');
            $table->integer('rooms')->default(0);
            $table->string('bar')->nullable();
            $table->time('start_time');
            $table->time('end_time');
            $table->string('ad_opts')->nullable();
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
        Schema::dropIfExists('leads');
    }
};
