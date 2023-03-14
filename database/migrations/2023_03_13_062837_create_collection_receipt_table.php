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
        Schema::create('collection_receipt', function (Blueprint $table) {
            $table->id();
            $table->string('description_of_goods');
            $table->float('price',8,2);
            $table->float('fees',8,2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
          
        Schema::dropIfExists('collection_receipt');
    }
};
