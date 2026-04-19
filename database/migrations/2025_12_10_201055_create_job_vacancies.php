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
        Schema::create('job_vacancies', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('title');
            $table->longText('description');
            $table->string('location');
            $table->string('salary');
            $table->enum('type', ['Full-time', 'Contract', 'Remote', 'Hybrid'])->default('Full-time');
            $table->timestamps();
            $table->softDeletes();
            //  RelationShips
            $table->foreignUuid('jobcategoryId')->constrained('job_categories')->restrictOnDelete();
            $table->foreignUuid('companyId')->constrained('companies')->restrictOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('job_vacancies');
    }
};
