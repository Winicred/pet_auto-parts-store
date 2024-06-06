<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CategoriesResource\Pages;
use App\Models\Category;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class CategoriesResource extends Resource
{
  protected static ?string $model = Category::class;

  protected static ?string $navigationGroup = "Parts";
  protected static ?string $navigationLabel = "Catalog Categories";
//  protected static ?string $navigationIcon = "heroicon-o-tag";
// use other icon
  protected static ?string $navigationIcon = "heroicon-o-folder";

  public static function form(Form $form): Form
  {
    return $form
      ->schema([
        TextInput::make('enName')
          ->required()
          ->autofocus()
          ->placeholder('Category Name (EN)')
          ->label('Name (EN)'),
        TextInput::make('etName')
          ->required()
          ->placeholder('Category Name (ET)')
          ->label('Name (ET)'),
        TextInput::make('ruName')
          ->required()
          ->placeholder('Category Name (RU)')
          ->label('Name (RU)'),
      ]);
  }

  public static function table(Table $table): Table
  {
    return $table
      ->columns([
        Tables\Columns\TextColumn::make('enName')
          ->label('Name (EN)'),
        Tables\Columns\TextColumn::make('etName')
          ->label('Name (ET)'),
        Tables\Columns\TextColumn::make('ruName')
          ->label('Name (RU)'),
      ])
      ->filters([
        //
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

  public static function getRelations(): array
  {
    return [
      //
    ];
  }

  public static function getPages(): array
  {
    return [
      'index' => Pages\ListCategories::route('/'),
      'create' => Pages\CreateCategories::route('/create'),
      'edit' => Pages\EditCategories::route('/{record}/edit'),
    ];
  }
}
