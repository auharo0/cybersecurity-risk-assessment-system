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
        Schema::create('asset_threat_library', function (Blueprint $table) {
            $table->id('threat_id');
            $table->unsignedBigInteger('asset_id');
            $table->string('threat_name');
            $table->text('threat_description');
            $table->text('vulnerabilities');
            $table->text('prevention_steps');
            $table->enum('severity_level', ['Low', 'Medium', 'High', 'Critical'])->default('Medium');
            $table->unsignedBigInteger('imported_by'); // Organization Manager who imported
            $table->timestamps();

            // Foreign keys
            $table->foreign('asset_id')->references('asset_id')->on('assets')->onDelete('cascade');
            $table->foreign('imported_by')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('asset_threat_library');
    }
};
