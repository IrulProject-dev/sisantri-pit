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
        Schema::create('assessment_template_components', function (Blueprint $table) {
            $table->id();
            $table->foreignId('assessment_template_id')->constrained('assessment_templates')->onDelete('cascade');
            $table->foreignId('assessment_component_id')->constrained('assessment_components')->onDelete('cascade');
            $table->decimal('weight', 5, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('assessment_template_components');
    }
};
