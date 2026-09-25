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
        Schema::create('municipal_staff_requests', function (Blueprint $table) {
            $table->id();
            $table->string('municipality_name');
            $table->string('contact_name');
            $table->string('contact_email');
            $table->string('position_title');
            $table->enum('employment_status', ['memur', 'sozlesmeli', 'isci', 'diger']);
            $table->unsignedSmallInteger('min_experience')->default(0);
            $table->string('work_location');
            $table->text('description');
            $table->string('attachment_path')->nullable();
            $table->boolean('consent_accepted')->default(false);
            $table->string('status')->default('beklemede');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('municipal_staff_requests');
    }
};
