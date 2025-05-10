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
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->string('thumbnail');
            $table->string('title');
            $table->enum('category', ['online', 'offline', 'hybrid']);
            $table->enum('type', ['free', 'paid']);
            $table->dateTime('start_date');
            $table->dateTime('end_date');
            $table->decimal('price', 10, 2)->nullable();
            $table->enum('participants', [
                'for all', 
                'for startups only', 
                'for pilots only', 
                'for startups & pilots'
            ]);
            $table->json('startup_participants')->nullable(); 
            $table->json('pilot_participants')->nullable();
            $table->text('custom_participants')->nullable();
            $table->longText('description');
            $table->json('gallery')->nullable();
            $table->json('collaterals')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};
