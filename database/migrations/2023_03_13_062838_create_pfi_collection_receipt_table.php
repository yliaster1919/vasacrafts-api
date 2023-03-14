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
        Schema::create('pfi_collection_receipt', function (Blueprint $table) {
            $table->id();
            $table->integer('pfi_id');
            $table->foreign('pfi_id')->references('id')->on('pro_forma_invoice');
            $table->integer('collection_receipt_id');
            $table->foreign('collection_receipt_id')->references('id')->on('collection_receipt');
            $table->integer('quantity');
            $table->float('sub_total',8,2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pfi_collection_receipt', function (Blueprint $table){
            $table->dropForeign(['pfi_id']);
            $table->dropColumn(['pfi_id']);
            $table->dropForeign(['collection_receipt_id']);
            $table->dropColumn(['collection_receipt_id']);
        }); 
        Schema::dropIfExists('pfi_collection_receipt');
    }
};
