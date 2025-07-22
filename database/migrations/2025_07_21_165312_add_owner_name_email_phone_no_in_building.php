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
        Schema::table('building', function (Blueprint $table) {
            //
            $table->string('owner_name')->after('building_name');
            $table->string('owner_email')->after('owner_name');
            $table->string('owner_phone_no')->after('owner_email');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('building', function (Blueprint $table) {
            //
            $table->dropColumn(['owner_name', 'owner_email', 'owner_phone_no']);
        });
    }
};
