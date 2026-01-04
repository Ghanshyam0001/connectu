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
        Schema::create('comments', function (Blueprint $table) {
            $table->id();
            $table->text('comment');

            // Foreign keys
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('content_id');
            $table->unsignedBigInteger('parent_id')->nullable(); // self relation for replies

            $table->timestamps();

            // Constraints
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('content_id')->references('id')->on('contents')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('parent_id')->references('id')->on('comments')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('comments');
    }
};
