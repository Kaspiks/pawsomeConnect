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
        Schema::create('pet_user', function (Blueprint $table) {
            $table->id();
            $table->unsignedBiginteger('user_id');
            $table->unsignedBiginteger('pet_id');

            $table->foreign('user_id')->references('id')
                 ->on('users')->onDelete('cascade');
            $table->foreign('pet_id')->references('id')
                ->on('pets')->onDelete('cascade');

            // $table->foreignId('user_id')->constrained()->onDelete('cascade');
            // $table->foreignId('pet_id')->constrained()->onDelete('cascade');

            // $table->id();
            // $table->foreignId('user_id')->constrained();
            // $table->foreignId('pet_id')->constrained();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pet_user');
    }
};
