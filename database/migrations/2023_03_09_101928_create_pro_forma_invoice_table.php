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
        Schema::create('pro_forma_invoice', function (Blueprint $table) {
            $table->id();
            $table->integer('client_id');
            $table->foreign('client_id')->references('id')->on('clients');
            $table->string('shipment_date');
            $table->string('currency');
            $table->float('total_bill',8,2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pro_forma_invoice', function (Blueprint $table){
            $table->dropForeign(['client_id']);
            $table->dropColumn(['client_id']);
        });    
        Schema::dropIfExists('pro_forma_invoice');
    }
};
