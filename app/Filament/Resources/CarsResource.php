<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CarsResource\Pages;
use App\Filament\Resources\CarsResource\RelationManagers\ModelsRelationManager;
use App\Filament\Resources\CarsResource\Widgets\CarStatsOverview;
use App\Models\Car;
use Closure;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;
use Ramsey\Uuid\Uuid;

class CarsResource extends Resource
{
  protected static ?string $model = Car::class;
  protected static ?string $navigationIcon = "heroicon-o-truck";
  protected static ?string $navigationGroup = "Vehicle";

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
    ];
  }

  public static function form(Form $form): Form
  {
    return $form->schema([
      TextInput::make("name")
        ->required()
        ->autofocus()
        ->unique(Car::class, "name", ignorable: fn($record) => $record)
        ->placeholder('Enter a Name e.g. Audi'),
      FileUpload::make("image")
        ->required()
        ->label("Photo")
        ->maxSize(1024 * 1024 * 5)
        ->image()
        ->hint("Max file size 5MB")
        ->imagePreviewHeight(250)
        ->acceptedFileTypes(["image/jpeg", "image/png"])
        ->disk("car_icons")
        ->visibility("public")
        ->preserveFilenames()
        ->maxFiles(1)
        ->getUploadedFileNameForStorageUsing(fn(TemporaryUploadedFile $file): string => Uuid::uuid4() . "." . $file->getClientOriginalExtension()),
    ]);
  }

  public static function table(Table $table): Table
  {
    return $table
      ->columns([
        TextColumn::make("name")
          ->sortable()
          ->searchable(),
        TextColumn::make("models.name")
          ->limitList()
          // if there is no models -> show badge with alert
          ->badge(fn($record) => $record->models->count() == 0)
          ->color(fn($record) => $record->models->count() == 0 ? "danger" : "")
          ->icon(fn($record) => $record->models->count() == 0 ? "heroicon-o-x-mark" : "")
          ->getStateUsing(fn($record) => $record->models->count() > 0 ? $record->models->count() : "No Models")
        ,
        ImageColumn::make("image")
          ->disk("car_icons")
          ->extraImgAttributes(["class" => "object-cover"])
          ->size(50)
          ->height("auto"),
      ])
      ->filters([
        //
      ])
      ->actions([
        EditAction::make(),
        DeleteAction::make()
      ])
      ->bulkActions([DeleteBulkAction::make()]);
  }

  public static function getRelations(): array
  {
    return [ModelsRelationManager::class];
  }

  public static function getPages(): array
  {
    return [
      "index" => Pages\ListCars::route("/"),
      "create" => Pages\CreateCars::route("/create"),
      "edit" => Pages\EditCars::route("/{record}/edit"),
    ];
  }

  public static function getWidgets(): array
  {
    return [
      CarStatsOverview::class
    ];
  }
}
