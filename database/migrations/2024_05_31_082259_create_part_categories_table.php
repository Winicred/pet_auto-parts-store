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
    Schema::create("part_categories", function (Blueprint $table) {
      $table->id();
      $table
        ->foreignId("modelId")
        ->constrained("car_models")
        ->cascadeOnDelete();
      $table
        ->foreignId("categoryId")
        ->constrained("categories")
        ->cascadeOnDelete();
      $table->string("enName");
      $table->string("etName");
      $table->string("ruName");
      $table->string("slug");
      $table->text("image");
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists("part_categories");
  }
};
