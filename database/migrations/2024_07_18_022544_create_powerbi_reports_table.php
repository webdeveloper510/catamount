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
        Schema::create('powerbi_reports', function (Blueprint $table) {
            $table->id();
            $table->string('report_name');
            $table->uuid('workspace_id')->nullable();
            $table->uuid('PBI_group_id');
            $table->uuid('PBI_report_id');
            $table->uuid('PBI_dataset_id');
            $table->text('PBI_embed_url');
            $table->string('permissions');
            $table->boolean('is_rls_enabled')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('powerbi_reports');
    }
};
