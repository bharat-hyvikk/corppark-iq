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
        Schema::table('qr_codes', function (Blueprint $table) {
            //
            // add office_id as foreign key
            $table->unsignedBigInteger('office_id')->after('unique_code');
            $table->foreign('office_id')->references('id')->on('offices')->onDelete('cascade')->after('unique_code');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('qr_codes', function (Blueprint $table) {
            //
        });
    }
};
