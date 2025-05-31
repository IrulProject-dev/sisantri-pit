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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('nis')->unique()->nullable()->comment('For santri role');
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->foreignId('batch_id')->nullable()->constrained('batches')->onDelete('restrict');
            $table->foreignId('division_id')->nullable()->constrained('divisions')->onDelete('restrict');
            $table->enum('role', ['superadmin', 'admin', 'mentor', 'santri', 'santri_mentor']);
            $table->date('date_of_birth')->nullable()->comment('For santri role');
            $table->enum('gender', ['male', 'female'])->nullable()->comment('For santri role');
            $table->string('place_of_birth')->nullable();
            $table->text('address')->nullable();
            $table->string('phone', 20)->nullable();
            $table->string('father_name')->nullable()->comment('For santri role');
            $table->string('father_phone', 20)->nullable()->comment('For santri role');
            $table->string('mother_name')->nullable()->comment('For santri role');
            $table->string('mother_phone', 20)->nullable()->comment('For santri role');
            $table->boolean('is_active')->default(true);
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->string('photo')->nullable();
            $table->rememberToken();
            $table->timestamps();

            // Add indexes for better performance
            $table->index('role');
            $table->index('division_id');
            $table->index('batch_id');

        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};
