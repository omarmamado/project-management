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
        Schema::create('cash_requests', function (Blueprint $table) {
            $table->id();
            $table->string('request_name');
            $table->text('reason');
            $table->date('request_date');
            $table->date('due_date');
            $table->decimal('amount');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('cash_category_id')->constrained()->onDelete('cascade');
            $table->enum('status', ['pending', 'approved_by_manager', 'approved_by_accounts', 'approved_by_gm', 'rejected'])->default('pending');
            $table->foreignId('approved_by_manager')->nullable()->constrained('users')->onDelete('set null');
            $table->foreignId('approved_by_accounts')->nullable()->constrained('users')->onDelete('set null');
            $table->foreignId('approved_by_gm')->nullable()->constrained('users')->onDelete('set null');
            $table->string('attachment')->nullable();
            $table->foreignId('project_id')->nullable()->constrained('projects')->onDelete('cascade'); 
            $table->foreignId('project_inquiries_id')->nullable()->constrained('project_inquiries')->onDelete('cascade');

            $table->foreignId('phase_id')->nullable()->constrained('project_inquiry_phases')->onDelete('cascade'); // إضافة هذا الحقل

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cash_requests');
    }
};
