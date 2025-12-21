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
        Schema::create('traders', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('profile_pic')->nullable();
            $table->decimal('profit_percentage', 8, 2);
            $table->decimal('amount_made', 18, 8);
            $table->integer('copies');
            $table->decimal('aum', 18, 8);
            $table->integer('leading_trades');
            $table->enum('direction', ['up', 'down']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('traders');
    }
};
