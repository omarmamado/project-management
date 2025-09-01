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
            $table->string('name');
            $table->string('phone')->nullable();
            $table->string('photo')->nullable();
            $table->string('email')->unique();
            $table->string('job_title')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password')->nullable();
            $table->foreignId('company_id')->constrained('companies')->onDelete('cascade')->nullable();
            $table->foreignId('department_id')->constrained('departments')->onDelete('cascade')->nullable();
            // $table->foreignId('team_id')->constrained('teams')->onDelete('cascade')->nullable(); // ربط المستخدم بالفريق
                $table->foreignId('team_id')->nullable()->constrained('teams')->onDelete('cascade');

            $table->enum('role', ['employee', 'hr', 'accounts', 'gm']); // دور المستخدم
            $table->boolean('is_manager')->default(false); // هل هو مدير؟
            $table->string('api_token', 80)->unique()->nullable()->default(null);
            $table->rememberToken();
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
