<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BodySeeder extends Seeder
{
  /**
   * Run the database seeds.
   */
  public function run(): void
  {
    $sqlFile = file_get_contents(database_path("sql/bodies.sql"));
    $sqlArray = explode(";", $sqlFile);

    foreach ($sqlArray as $sql) {
      if (trim($sql) != "") {
        DB::statement($sql);
      }
    }

    $this->command->info("Bodies table seeded!");
  }
}
