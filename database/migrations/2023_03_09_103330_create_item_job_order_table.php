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
        Schema::create('item_job_orders', function (Blueprint $table) {
            $table->id();
            $table->integer('job_order_id');
            $table->foreign('job_order_id')->references('id')->on('job_orders');
            $table->integer('item_id');
            $table->foreign('item_id')->references('id')->on('items');
            $table->bigInteger('quantity');
            $table->float('total_points',8,2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('item_job_order');
    }
};
