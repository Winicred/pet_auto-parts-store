<?php

namespace App\Filament\Resources\CarsResource\Pages;

use App\Filament\Resources\CarsResource;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Str;

class CreateCars extends CreateRecord
{
  protected static string $resource = CarsResource::class;

  protected function mutateFormDataBeforeCreate(array $data): array
  {
    $data['slug'] = Str::slug($data['name']);

    return $data;
  }
}
