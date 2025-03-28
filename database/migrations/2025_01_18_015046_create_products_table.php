<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('title' , 2000);
            $table->string('slug' , 2000)->nullable();
            $table->string('image' )->nullable();
            $table->string('image_mime')->nullable();
            $table->string('image_size')->nullable();
            $table->longText('description')->nullable();
            $table->decimal('price', 10)->nullable();
            // $table->foreignIdFor(User::class , 'created_by')->nullable();
            // $table->foreignIdFor(User::class , 'updated_by')->nullable();
            // $table->foreignIdFor(User::class , 'deleted_by')->nullable();
            $table->foreignId('created_by')->constrained('users')->nullable();
            $table->foreignId('updated_by')->constrained('users')->nullable();
            // $table->foreignId('deleted_by')->constrained('users')->nullable();
            // $table->foreignId('deleted_by')->constrained('users')->nullable()->default(null);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
