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
        Schema::create('job_applications', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->enum('status', ['Pending', 'Accepted', 'Rejected'])->default('Pending');
            $table->float('aiGeneratedScore', 2)->default(0);
            $table->longText('aiGeneratedFeedback')->nullable();
            $table->timestamps();
            $table->softDeletes('deleted_at');
            //  RelationShips
            $table->foreignUuid('jobVacancyId')->constrained('job_vacancies')->restrictOnDelete();
            $table->foreignUuid('userId')->constrained('users')->restrictOnDelete();
            $table->foreignUuid('resumeId')->constrained('resumes')->restrictOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('job_applications');
    }
};
