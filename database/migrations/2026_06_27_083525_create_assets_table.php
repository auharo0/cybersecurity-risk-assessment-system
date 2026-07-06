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
        Schema::create('assets', function (Blueprint $table) {
            $table->id('asset_id');
            $table->string('asset_name', 100);
            $table->enum('asset_type', ['Hardware', 'Software', 'Database', 'Cloud Service']);
            $table->text('description')->nullable();

            $table->unsignedBigInteger('managed_by')->nullable();
            $table->foreign('managed_by')->references('id')->on('users')->onDelete('set null');

            $table->unsignedBigInteger('session_id')->nullable();
            $table->foreign('session_id')->references('session_id')->on('assessment_sessions')->onDelete('cascade');

            $table->timestamp('created_at')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('assets');
    }
};
