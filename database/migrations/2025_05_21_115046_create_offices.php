<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    //     2.	Office Management
    // Add New Office
    // 	Editable Text: Office No, Office Name, Office Owner Email, Office OwnerName, Office OwnerPhone Number, Vehicle Limit.

    // Edit Office Info
    // 	Editable Text: Office No, Office Name, Office Owner Email, Office Owner Name, Office Owner Phone Number, Vehicle Limit.

    // Delete Office(Soft)
    // Note: only allowed to delete if no vehicles isattached.
    // Shown list of Offices Data
    // 	Text: Office No, Office Name, Office Owner Email, Office Owner Name, Office Owner Phone Number, Vehicle Limit.

    public function up(): void
    {
        Schema::create('offices', function (Blueprint $table) {
            $table->id();
            $table->string('office_number')->unique();
            $table->string('office_name');
            $table->string('owner_email')->unique();
            $table->string('owner_name');
            $table->string('owner_phone_number');
            $table->integer('vehicle_limit');
            $table->enum("status", ['Active', 'Inactive'])->default('Active');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('offices');
    }
};
