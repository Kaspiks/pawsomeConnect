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
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description')->nullable();
            $table->date('date');
            $table->integer('max_amount_of_people');
            $table->decimal('price', 10, 2);
            $table->string('location');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users_events', function (Blueprint $table) {
            $table->dropForeign(['event_id']); // Replace 'child_table_name' and 'event_id' with the actual names
        });

        Schema::dropIfExists('events');
    }
};
