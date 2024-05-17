<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMeetingsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('meetings', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->string('name')->nullable();  
            $table->string('email');
            $table->string('lead_address');    
            $table->string('eventname')->nullable();    
            $table->string('relationship')->nullable();  
            $table->integer('phone')->default(0);
            $table->string('alter_name')->nullable();
            $table->integer('alter_phone')->nullable();
            $table->string('alter_email')->nullable();
            $table->string('alter_relationship')->nullable();
            $table->string('alter_lead_address')->nullable(); 
            $table->string('company_name')->nullable();    
            $table->integer('status')->default(0);
            $table->date('start_date');
            $table->date('end_date');
            $table->time('start_time');
            $table->time('end_time');
            $table->string('description')->nullable();
            $table->integer('attendees_lead')->default(0);
            $table->integer('guest_count')->default(0);
            $table->string('function')->nullable();
            $table->string('floor_plan')->nullable();
            $table->string('func_package')->nullable();
            $table->string('bar_package')->nullable();
            $table->string('venue_selection')->nullable();
            $table->string('spcl_request')->nullable();
            $table->integer('room')->default(0);
            $table->string('meal')->nullable();
            $table->string('bar')->nullable();
            $table->string('type')->nullable();
            $table->string('ad_opts')->nullable();
            $table->integer('total')->default(0);
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
        Schema::dropIfExists('meetings');
    }
};
