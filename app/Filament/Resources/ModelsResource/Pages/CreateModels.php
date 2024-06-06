<?php

namespace App\Filament\Resources\ModelsResource\Pages;

use App\Filament\Resources\ModelsResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Str;

class CreateModels extends CreateRecord
{
    protected static string $resource = ModelsResource::class;

  protected function mutateFormDataBeforeCreate(array $data): array
  {
    $data['slug'] = Str::slug($data['name']);

    return $data;
  }
}
