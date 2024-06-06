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
    Schema::create('model_modifications', function (Blueprint $table) {
      $table->id()->autoIncrement();
      $table->foreignId("modelId")->constrained("car_models")->cascadeOnDelete();
      $table->foreignId("bodyId")->constrained("bodies")->cascadeOnDelete();
      $table->string("engineCode");
      $table->integer("engineCapacity");
      $table->integer("enginePower")->nullable();
      $table->integer("engineTorque")->nullable();
      $table->enum("engineFuel", ["petrol", "diesel", "hybrid", "electric", "gas"]);
      $table->float("engineFuelConsumptionCity")->nullable();
      $table->float("engineFuelConsumptionHighway")->nullable();
      $table->float("engineFuelConsumptionCombined")->nullable();
      $table->string("engineInjectionType")->nullable();
      $table->integer("engineCylinderCount")->nullable();
      $table->integer("engineValveCount")->nullable();
      $table->enum("transmissionType", ["automatic", "manual", "robotic", "variator"]);
      $table->integer("transmissionGearCount")->nullable();
      $table->enum("transmissionDrive", ["front", "rear", "full"]);
      $table->float("weight")->nullable();
      $table->float("clearance")->nullable();
      $table->integer("fuelTankCapacity")->nullable();
      $table->integer("trunkCapacity")->nullable();
      $table->integer("seatsCount")->nullable();
      $table->integer("doorsCount")->nullable();
      $table->date("releasedAt");
      $table->date("stoppedAt")->nullable();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('model_modifications');
  }
};
