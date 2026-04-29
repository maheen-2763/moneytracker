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
        Schema::create('expenses', function (Blueprint $table) {
        $table->id();
        $table->foreignId('user_id')->constrained()->cascadeOnDelete();
        $table->string('title', 150);
        $table->text('description')->nullable();
        $table->decimal('amount', 10, 2);
        $table->string('category', 60); // food, travel, office, health, other
        $table->date('expense_date');
        $table->string('receipt_path')->nullable();
        $table->timestamps();
        $table->softDeletes(); 
        $table->index(['user_id', 'expense_date']);
        // never hard-delete financial records
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('expenses');
    }
};
