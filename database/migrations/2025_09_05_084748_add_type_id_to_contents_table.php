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
        Schema::table('contents', function (Blueprint $table) {
            $table->dropForeign(['type_id']); // ignore error if doesn't exist
            $table->unsignedBigInteger('type_id')->nullable()->after('category_id')->change();
            $table->foreign('type_id')
                ->references('id')
                ->on('types')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('contents', function (Blueprint $table) {
            //
        });
    }
};
