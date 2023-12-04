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
        Schema::create('works', function (Blueprint $table) {
            $table->id();
            $table->string('image');
            $table->string('title');
            $table->unsignedBigInteger('category_id');
            $table->string('telephone');
            $table->string('min_budget');
            $table->string('max_budget');
            $table->enum('type_of_work', ['Kerja Lepas', 'Part Time', 'Full Time', 'Kontrak']);
            $table->date('start_date');
            $table->text('description');
            $table->string('latitude');
            $table->string('longitude');
            $table->timestamps();
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('works');
    }
};
