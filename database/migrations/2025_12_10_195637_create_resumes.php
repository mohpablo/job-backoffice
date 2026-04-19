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
        Schema::create('resumes', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('fileName');
            $table->string('fileUrl');
            $table->longText('summary');
            $table->longText('contactDetails');
            $table->longText('education');
            $table->longText('experience');
            $table->longText('skills');
            $table->timestamps();
            $table->softDeletes('deleted_at');

            // Relationships
            $table->foreignUuid('userId')->constrained('users')->restrictOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('resumes');
    }
};
