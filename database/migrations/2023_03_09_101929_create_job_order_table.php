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
        Schema::create('job_orders', function (Blueprint $table) {
            $table->id();
            $table->integer('client_id');
            $table->foreign('client_id')->references('id')->on('clients');
            $table->string('date_release');
            $table->string('contact_num');
            $table->string('delivery_address');
            $table->string('pfi_reference_number');
            $table->string('shipment_date');
            $table->string('approved_by');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('job_order');
    }
};
