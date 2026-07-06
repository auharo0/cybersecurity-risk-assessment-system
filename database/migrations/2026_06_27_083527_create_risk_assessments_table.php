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
        Schema::create('risk_assessments', function (Blueprint $table) {
            $table->id('assessment_id');

            // Foreign Keys
            $table->unsignedBigInteger('session_id');
            $table->unsignedBigInteger('asset_id');
            $table->unsignedBigInteger('assessed_by');

            $table->foreign('session_id')->references('session_id')->on('assessment_sessions')->onDelete('cascade');
            $table->foreign('asset_id')->references('asset_id')->on('assets')->onDelete('cascade');
            $table->foreign('assessed_by')->references('id')->on('users')->onDelete('cascade');

            // Assessment Data
            $table->string('threat_description', 255);
            $table->string('vulnerability_description', 255);
            $table->string('cve_reference', 50)->nullable();

            // Laravel handles MIN/MAX checks usually in the Request Validation, but we define the type here
            $table->tinyInteger('likelihood')->unsigned(); // 1 to 3
            $table->tinyInteger('impact')->unsigned();     // 1 to 3
            $table->integer('risk_score');
            $table->enum('risk_classification', ['Low', 'Medium', 'High']);

            // Remediation
            $table->enum('status', ['Open', 'In Progress', 'Resolved', 'Accepted'])->default('Open');
            $table->text('mitigation_plan')->nullable();

            $table->timestamp('assessment_date')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('risk_assessments');
    }
};
