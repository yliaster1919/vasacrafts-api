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
            $table->integer('pfi_id');
            $table->foreign('pfi_id')->references('id')->on('pro_forma_invoice');
            $table->string('shipment_date');
            $table->string('approved_by');
            $table->float('total_units',8,2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('job_orders', function (Blueprint $table){
            $table->dropForeign(['client_id']);
            $table->dropForeign(['pfi_id']);
            $table->dropColumn(['client_id']);
            $table->dropColumn(['pfi_id']);    
        });    
        Schema::dropIfExists('job_orders');
    }
};
