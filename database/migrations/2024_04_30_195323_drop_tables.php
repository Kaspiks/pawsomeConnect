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
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('posts_comments');
        Schema::dropIfExists('posts_attachments');
        Schema::dropIfExists('posts');
        Schema::dropIfExists('events_users');
        Schema::dropIfExists('events');
        Schema::dropIfExists('services');
        Schema::dropIfExists('users_services');
        Schema::dropIfExists('services_categories');
        Schema::dropIfExists('pets');
        Schema::dropIfExists('users_pets');
        Schema::dropIfExists('users');
    }
};
