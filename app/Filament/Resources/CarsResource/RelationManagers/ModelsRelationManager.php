<?php

namespace App\Filament\Resources\CarsResource\RelationManagers;

use App\Models\Car;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;
use Ramsey\Uuid\Uuid;

class ModelsRelationManager extends RelationManager
{
  protected static string $relationship = 'models';
  protected static ?string $recordTitleAttribute = "carId";

  public function form(Form $form): Form
  {
    return $form
      ->schema([
        Select::make("carId")
          ->required()
          ->label("Car")
          ->searchable()
          ->selectablePlaceholder(false)
          ->placeholder("Select a Car")
          ->options(Car::orderBy('name', 'asc')->pluck("name", "id")),
        TextInput::make("name")
          ->required()
          ->placeholder('Enter a Model e.g. A6'),
        TextInput::make("releasedAt")
          ->type('month')
          ->required()
          ->label("Production Start Date")
          ->default(now())
          ->placeholder('Enter a year e.g. 03.2018'),
        TextInput::make("stoppedAt")
          ->type('month')
          ->label("Production End Date"),
        FileUpload::make("image")
          ->required()
          ->label("Car Model Image")
          ->maxSize(1024 * 1024 * 5)
          ->image()
          ->hint("Max file size 5MB")
          ->imagePreviewHeight(250)
          ->acceptedFileTypes(["image/jpeg", "image/png"])
          ->disk(function (Get $get) {
            $car = Car::find($get("carId"));

            resolve("filesystem")->forgetDisk("car_models");
            app()["config"]->set("filesystems.disks.car_models", [
              "driver" => "local",
              "root" => public_path(
                "images/cars/models/" . $car->slug
              ),
              "url" => "/images/cars/models/" . $car->slug,
              "visibility" => "public",
              "throw" => false,
            ]);

            return "car_models";
          })
          ->visibility("public")
          ->preserveFilenames()
          ->getUploadedFileNameForStorageUsing(fn(TemporaryUploadedFile $file): string => Uuid::uuid4() . "." . $file->getClientOriginalExtension()),
      ]);
  }

  public function table(Table $table): Table
  {
    return $table
      ->recordTitleAttribute('carId')
      ->columns([
        Tables\Columns\TextColumn::make("name")->searchable(),
        Tables\Columns\TextColumn::make("releasedAt")->label(
          "Release Start Date"
        ),
        Tables\Columns\TextColumn::make("stoppedAt")
          ->label("Release End Date")
          ->getStateUsing(function ($record) {
            return $record->stoppedAt ?? "Present";
          }),
        Tables\Columns\ImageColumn::make("image")
          ->extraImgAttributes(["class" => "h-auto object-cover"])
          ->size(100)
          ->height("auto")
          ->label("Image")
          ->disk(function ($record) {
            resolve("filesystem")->forgetDisk("car_models");
            app()["config"]->set("filesystems.disks.car_models", [
              "driver" => "local",
              "root" => public_path(
                "images/cars/models/" . $record->car->slug
              ),
              "url" =>
                "/images/cars/models/" . $record->car->slug,
              "visibility" => "public",
              "throw" => false,
            ]);

            return "car_models";
          }),
      ])
      ->filters([
        //
      ])
      ->headerActions([
        Tables\Actions\CreateAction::make()
          ->mutateFormDataUsing(function (array $data): array {
            $data['slug'] = Str::slug($data['name']);
            $data['releasedAt'] = substr($data['releasedAt'], 0, 7);
            if (isset($data['stoppedAt'])) {
              $data['stoppedAt'] = substr($data['stoppedAt'], 0, 7);
            }

            return $data;
          }),
      ])
      ->actions([
        Tables\Actions\EditAction::make(),
        Tables\Actions\DeleteAction::make(),
      ])
      ->bulkActions([
        Tables\Actions\BulkActionGroup::make([
          Tables\Actions\DeleteBulkAction::make(),
        ]),
      ]);
  }
}
