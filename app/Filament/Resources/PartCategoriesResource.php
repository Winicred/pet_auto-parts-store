<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PartCategoriesResource\Pages;
use App\Filament\Resources\PartCategoriesResource\RelationManagers\PartsRelationManager;
use App\Filament\Resources\PartCategoriesResource\Widgets\PartCategoryStatsOverview;
use App\Models\Car;
use App\Models\CarModel;
use App\Models\Category;
use App\Models\PartCategory;
use Closure;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Forms\Set;
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

class PartCategoriesResource extends Resource
{
  protected static ?string $model = PartCategory::class;
  protected static ?string $navigationGroup = "Parts";
  protected static ?string $navigationLabel = "Categories (Parts)";
  protected static ?string $navigationIcon = "heroicon-o-tag";

  public static function getNavigationBadge(): ?string
  {
    return static::getModel()::count();
  }

  public static function getGloballySearchableAttributes(): array
  {
    return [
      'etName',
      'enName',
      'ruName',
    ];
  }

  public static function getRecordTitle(?Model $record): ?string
  {
    return $record?->enName;
  }

  public static function getGlobalSearchResultDetails(Model $record): array
  {
    return [
      'Name (ET)' => $record->etName,
      'Name (EN)' => $record->enName,
      'Name (RU)' => $record->ruName,
    ];
  }

  public static function form(Form $form): Form
  {
    return $form->schema([
      Select::make("modelId")
        ->relationship("model", "modelId")
        ->required()
        ->searchable()
        ->label("Car Model")
        ->validationAttribute("model")
        ->placeholder("Select a Car Model")
        ->getSearchResultsUsing(function (string $search) {
          return CarModel::with('car')
            ->whereHas('car', function ($query) use ($search) {
              $query->where("name", "like", "%{$search}%");
            })
            ->orWhere("name", "like", "%{$search}%")
            ->orWhere("releasedAt", "like", "%{$search}%")
            ->orWhere("stoppedAt", "like", "%{$search}%")
            ->get()
            ->mapWithKeys(function ($model) {
              return [$model->id => $model->car->name . " " . $model->name . " (" . $model->releasedAt . ($model->stoppedAt !== null ? " - " . $model->stoppedAt : null) . ")"];
            });
        })
        ->options(function () {
          return CarModel::with('car')->whereHas("car", fn($query) => $query->orderBy("name", "asc"))->get()->mapWithKeys(function ($model) {
            return [$model->id => $model->car->name . " " . $model->name . " (" . $model->releasedAt . ($model->stoppedAt !== null ? " - " . $model->stoppedAt : null) . ")"];
          });
        }),
      Select::make("categoryId")
        ->searchable()
        ->required()
        ->label("Category")
        ->placeholder("Select a Category")
        ->options(
          Category::orderBy("enName", "asc")->pluck("enName", "id")
        )
        ->createOptionForm([
          TextInput::make("enName")
            ->label("Name (EN)")
            ->placeholder("Name (EN)")
            ->required(),
          TextInput::make("etName")
            ->label("Name (ET)")
            ->placeholder("Name (ET)")
            ->required(),
          TextInput::make("ruName")
            ->label("Name (RU)")
            ->placeholder("Name (RU)")
            ->required(),
        ])
        ->createOptionUsing(function (array $data): string {
          return Category::create($data)->id;
        }),
      TextInput::make("etName")
        ->label("Name (ET)")
        ->placeholder("Name (ET)")
        ->required(),
      TextInput::make("enName")
        ->label("Name (EN)")
        ->placeholder("Name (EN)")
        ->required(),
      TextInput::make("ruName")
        ->label("Name (RU)")
        ->placeholder("Name (RU)")
        ->required(),
      FileUpload::make("image")
        ->required()
        ->label("Photo")
        ->maxSize(1024 * 1024 * 5)
        ->image()
        ->hint("Max file size 5MB")
        ->imagePreviewHeight(250)
        ->acceptedFileTypes(["image/jpeg", "image/png"])
        ->disk(function ($record, callable $get) {
          $car = $get("modelId") != "" ? CarModel::find($get("modelId"))->car : $record->model->car;

          if (!file_exists(public_path("images/parts/" . $car->slug))) {
            mkdir(public_path("images/parts/" . $car->slug), 0777, true);
          }

          resolve("filesystem")->forgetDisk($car->slug);
          app()["config"]->set("filesystems.disks." . $car->slug, [
            "driver" => "local",
            "root" => public_path(
              "images/partCategories/" . $car->slug
            ),
            "url" => "/images/partCategories/" . $car->slug,
            "visibility" => "public",
            "throw" => false,
          ]);

          return $car->slug;
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
        TextColumn::make("model.car.name")
          ->label("Brand")
          ->sortable()
          ->searchable(),
        TextColumn::make("model.name")
          ->label("Model")
          ->sortable()
          ->searchable(),
        TextColumn::make("enName")
          ->label("Name (EN)")
          ->sortable()
          ->searchable(),
        TextColumn::make("ruName")
          ->label("Name (RU)")
          ->sortable()
          ->searchable(),
        TextColumn::make("etName")
          ->label("Name (ET)")
          ->sortable()
          ->searchable(),
        ImageColumn::make("image")
          ->disk(function ($record) {
            $car = Car::find($record->model->carId);

            if (!file_exists(public_path("images/parts/" . $car->slug))) {
              mkdir(public_path("images/parts/" . $car->slug), 0777, true);
            }

            resolve("filesystem")->forgetDisk($car->slug);
            app()["config"]->set("filesystems.disks." . $car->slug, [
              "driver" => "local",
              "root" => public_path(
                "images/partCategories/" . $car->slug
              ),
              "url" => "/images/partCategories/" . $car->slug,
              "visibility" => "public",
              "throw" => false,
            ]);

            return $car->slug;
          })
          ->size(100),
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
    return [
      PartsRelationManager::class
    ];
  }

  public static function getPages(): array
  {
    return [
      "index" => Pages\ListPartCategories::route("/"),
      "create" => Pages\CreatePartCategories::route("/create"),
      "edit" => Pages\EditPartCategories::route("/{record}/edit"),
    ];
  }

  public static function getWidgets(): array
  {
    return [
      PartCategoryStatsOverview::class
    ];
  }
}
