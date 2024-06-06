<?php

namespace App\Filament\Resources\PartCategoriesResource\RelationManagers;

use App\Models\ModelModification;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Support\RawJs;
use Filament\Tables\Actions\CreateAction;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Support\Str;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;
use Ramsey\Uuid\Uuid;

class PartsRelationManager extends RelationManager
{
  protected static string $relationship = 'parts';

  protected static ?string $recordTitleAttribute = 'categoryId';

  public function form(Form $form): Form
  {
    return $form
      ->schema([
        Select::make('modificationId')
          ->relationship('modification', 'id')
          ->label("Modification")
          ->searchable()
          ->placeholder('Select a Modification')
          ->options(function () {
            return ModelModification::orderBy('engineCode', 'asc')
              ->get()
              ->mapWithKeys(function ($modification) {
                return [$modification->id => "{$modification->model->car->name} {$modification->model->name} - #{$modification->engineCode} ({$modification->engineCapacity}), {$modification->transmissionType}"];
              });
          }),
        TextInput::make('enName')
          ->autofocus()
          ->required()
          ->label("English Name")
          ->placeholder('Enter a English Name'),
        TextInput::make('etName')
          ->required()
          ->label("Estonian Name")
          ->placeholder('Enter a Estonian Name'),
        TextInput::make('ruName')
          ->required()
          ->label("Russian Name")
          ->placeholder('Enter a Russian Name'),
        FileUpload::make('image')
          ->required()
          ->label("Photo")
          ->maxSize(1024 * 1024 * 5)
          ->image()
          ->hint("Max file size 5MB")
          ->imagePreviewHeight(250)
          ->acceptedFileTypes(["image/jpeg", "image/png"])
          ->disk(function (RelationManager $livewire) {
            $car_slug = $livewire->ownerRecord->model->car->slug;

            if (!file_exists(public_path("images/parts/" . $car_slug))) {
              mkdir(public_path("images/parts/" . $car_slug), 0777, true);
            }

            resolve("filesystem")->forgetDisk($car_slug);
            app()["config"]->set("filesystems.disks." . $car_slug, [
              "driver" => "local",
              "root" => public_path(
                "images/parts/" . $car_slug
              ),
              "url" => "/images/parts/" . $car_slug,
              "visibility" => "public",
              "throw" => false,
            ]);

            return $car_slug;
          })
          ->visibility("public")
          ->preserveFilenames()
          ->getUploadedFileNameForStorageUsing(fn(TemporaryUploadedFile $file): string => Uuid::uuid4() . "." . $file->getClientOriginalExtension()),
        TextInput::make('price')
          ->mask(RawJs::make(<<<'JS'
              $money($input, '.', ',', 2)
            JS))
          ->maxValue(999999)
          ->maxLength(10)
          ->required()
          ->placeholder('Enter a Price'),
        TextInput::make('quantity')
          ->required()
          ->placeholder('Enter a Quantity'),
        TextInput::make('manufacturer')
          ->required()
          ->placeholder('Enter a Code'),
        TextInput::make('code')
          ->required()
          ->dehydrateStateUsing(fn(string $state) => Str::upper($state))
          ->placeholder('Enter a Code'),
        Select::make('color')
          ->placeholder('Select a Color')
          ->options([
            "black" => "Black",
            "white" => "White",
            "silver" => "Silver",
            "gray" => "Gray",
            "red" => "Red",
            "blue" => "Blue",
            "green" => "Green",
            "yellow" => "Yellow",
            "brown" => "Brown",
            "orange" => "Orange",
            "purple" => "Purple",
            "pink" => "Pink",
            "gold" => "Gold",
            "beige" => "Beige",
          ]),
        Select::make('location')
          ->placeholder('Select a Location')
          ->options([
            "front" => "Front",
            "back" => "Back",
            "left" => "Left",
            "right" => "Right",
            "top" => "Top",
            "bottom" => "Bottom",
          ]),
        TextInput::make('width')
          ->placeholder('Enter a Width')
          ->maxLength(4)
          ->maxValue(9999),
        TextInput::make('height')
          ->placeholder('Enter a Height')
          ->maxLength(4)
          ->maxValue(9999),
        TextInput::make('length')
          ->placeholder('Enter a Length')
          ->maxLength(4)
          ->maxValue(9999),
        Select::make('material')
          ->placeholder('Select a Material')
          ->options([
            "steel" => "Steel",
            "aluminium" => "Aluminium",
            "plastic" => "Plastic",
            "glass" => "Glass",
          ]),
      ]);
  }

  public function table(Table $table): Table
  {
    return $table
      ->columns([
        TextColumn::make('id')
          ->sortable()
          ->searchable(),
        TextColumn::make('etName')
          ->label("Estonian Name")
          ->limit(15)
          ->tooltip(function (TextColumn $column): ?string {
            return $column->getState();
          })
          ->sortable()
          ->searchable(),
        TextColumn::make('enName')
          ->label("English Name")
          ->limit(15)
          ->tooltip(function (TextColumn $column): ?string {
            return $column->getState();
          })
          ->sortable()
          ->searchable(),
        TextColumn::make('ruName')
          ->label("Russian Name")
          ->limit(15)
          ->tooltip(function (TextColumn $column): ?string {
            return $column->getState();
          })
          ->sortable()
          ->searchable(),
        TextColumn::make('category.model.car.name')
          ->label("Car Brand")
          ->sortable()
          ->searchable(),
        TextColumn::make('price')
          ->sortable()
          ->money("EUR", true)
          ->searchable(),
        TextColumn::make('quantity')
          ->sortable()
          ->searchable(),
      ])
      ->filters([
        //
      ])
      ->headerActions([
        CreateAction::make(),
      ])
      ->actions([
        EditAction::make()->modalHeading(function ($record) {
          return "Edit " . $record->enName;
        }),
        DeleteAction::make()->modalHeading(function ($record) {
          return "Delete " . $record->enName;
        }),
      ])
      ->bulkActions([
        DeleteBulkAction::make(),
      ]);
  }
}
