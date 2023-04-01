<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('product_list', function (Blueprint $table) {
            $table->id();
            $table->dateTime('date_time_updated');
            $table->string('created_products', 999)->nullable();
            $table->string('updated_products', 999)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_list');
    }
};