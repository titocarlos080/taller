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
        //
        Schema::create('assistance_requests_workshop', function (Blueprint $table) {
            $table->id();
            $table->string('price')->nullable();
            $table->unsignedBigInteger('workshop_id')->nullable()->foreign('workshop_id')->references('id')->on('workshops')->onDelete('set null');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
        Schema::dropIfExists('assistance_requests_workshop');
    }
};
