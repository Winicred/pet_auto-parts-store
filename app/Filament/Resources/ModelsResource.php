<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ModelsResource\Pages;
use App\Filament\Resources\ModelsResource\RelationManagers;
use App\Filament\Resources\ModelsResource\RelationManagers\ModificationsRelationManager;
use App\Models\Car;
use App\Models\CarModel;
use Closure;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Get;
use Filament\Resources\Resource;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;
use Ramsey\Uuid\Uuid;

class ModelsResource extends Resource
{
  protected static ?string $model = CarModel::class;
  protected static ?string $navigationIcon = 'heroicon-o-document-chart-bar';
  protected static ?string $navigationGroup = "Vehicle";
  protected static ?string $navigationLabel = "Models";

  public static function getNavigationBadge(): ?string
  {
    return static::getModel()::count();
  }

  public static function getGloballySearchableAttributes(): array
  {
    return [
      'name',
    ];
  }

  public static function getRecordTitle(?Model $record): ?string
  {
    return $record?->name;
  }

  public static function getGlobalSearchResultDetails(Model $record): array
  {
    return [
      'Name' => $record->name,
      'Car' => $record->car->name,
    ];
  }

  public static function form(Forms\Form $form): Forms\Form
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

  public static function table(Table $table): Table
  {
    return $table
      ->columns([
        TextColumn::make("name")->sortable()->searchable(),
        TextColumn::make("releasedAt")
          ->sortable()
          ->searchable()
          ->label("Release Start Date"),
        TextColumn::make("stoppedAt")
          ->label("Release End Date")
          ->sortable()
          ->searchable()
          ->getStateUsing(fn($record) => $record->stoppedAt ? Carbon::parse($record->stoppedAt)->format('m.Y') : 'Present'),
        ImageColumn::make("image")
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
        SelectFilter::make("carId")
          ->label("Car")
          ->placeholder("All")
          ->options(
            fn() => Car::query()
              ->with("models")
              ->whereHas("models", function (Builder $query) {
                // where carId is not null
                $query->whereNotNull("carId");
              })
              ->get()
              ->mapWithKeys(fn($car) => [
                $car->id => $car->name,
              ])
              ->toArray()
          )
          ->query(function (Builder $query, array $data) {
            if (empty($data["value"])) {
              return $query->get();
            }

            return $query->where("carId", $data["value"]);
          }),
        SelectFilter::make("stoppedAt")
          ->label("Production Status")
          ->placeholder("All")
          ->options([
            'null' => 'In Production',
            'not_null' => 'Not in Production',
          ])
          ->query(function (Builder $query, array $data) {
            if ($data["value"] === "null") {
              $query->whereNull("stoppedAt");
            } elseif ($data["value"] === "not_null") {
              $query->whereNotNull("stoppedAt");
            }

            return $query;
          }),
      ])
      ->actions([
        EditAction::make()->modalHeading(fn($record) => "Edit " . $record->name),
        DeleteAction::make(),
      ])
      ->bulkActions([DeleteBulkAction::make()]);
  }

  public static function getRelations(): array
  {
    return [
      ModificationsRelationManager::class,
    ];
  }

  public static function getPages(): array
  {
    return [
      'index' => Pages\ListModels::route('/'),
      'create' => Pages\CreateModels::route('/create'),
      'edit' => Pages\EditModels::route('/{record}/edit'),
    ];
  }
}
