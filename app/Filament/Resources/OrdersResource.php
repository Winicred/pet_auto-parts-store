<?php

namespace App\Filament\Resources;

use App\Filament\Resources\OrderProductsResource\RelationManagers\OrderProductsRelationManager;
use App\Filament\Resources\OrdersResource\Pages;
use App\Models\Order;
use Carbon\Carbon;
use Filament\Resources\Resource;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class OrdersResource extends Resource
{
  protected static ?string $model = Order::class;
  protected static ?string $navigationIcon = "heroicon-o-shopping-bag";
  protected static ?string $navigationGroup = "Orders";

   public static function getNavigationBadge(): ?string
   {
     return static::getModel()::count();
   }

  public static function canViewAny(): bool
  {
    return auth()->user()->isAdmin();
  }

  public static function form(\Filament\Forms\Form $form): \Filament\Forms\Form
  {
    return $form->schema([
      //
    ]);
  }

  public static function table(Table $table): Table
  {
    return $table
      ->columns([
        TextColumn::make("user.name")
          ->sortable()
          ->formatStateUsing(function ($state, $record) {
            return $record->user !== null ? $record->user->name : 'Unknown User';
          })
          ->url(
            fn($record) => $record->user !== null ? "/admin/users/{$record->user->id}/edit" : null
          )
          ->tooltip(function ($record) {
            return $record->user !== null ? "Click to Edit User" : null;
          })
          ->searchable(),
        TextColumn::make("amount")
          ->sortable()
          ->searchable()
          ->label("Total Price")
          ->money("eur")
          ->tooltip("Total Price"),
        TextColumn::make("status")
          ->badge()
          ->sortable()
          ->searchable()
          ->label("Status")
          ->color(static function ($state) {
            return match ($state) {
              "paid" => "success",
              "unpaid" => "danger",
              default => "warning",
            };
          })
          ->icon(static function ($state) {
            return match ($state) {
              "paid" => "heroicon-o-check-circle",
              "unpaid" => "heroicon-o-exclamation-circle",
              default => "heroicon-o-question-mark-circle",
            };
          })
          ->formatStateUsing(function (string $state) {
            return match ($state) {
              "paid" => "Paid",
              "unpaid" => "Unpaid",
              default => "Unknown",
            };
          })
          ->tooltip(function (TextColumn $column): ?string {
            $state = $column->getState();

            return match ($state) {
              "paid" => "The order has been paid with Stripe",
              "unpaid" => "The order has not been paid",
              default => "The order status is unknown",
            };
          }),
        TextColumn::make("boughtAt")
          ->sortable()
          ->searchable()
          ->tooltip("Date of Purchase")
          ->formatStateUsing(function ($state) {
            return Carbon::make($state)->format("d.m.Y H:i");
          }),
      ])
      ->defaultSort("boughtAt", "desc")
      ->filters([
        //
      ])
      ->actions([
        ViewAction::make()
          ->label("View")
          ->icon("heroicon-o-eye")
          ->color("primary"),
        DeleteAction::make(),
      ])
      ->bulkActions([DeleteBulkAction::make()]);
  }

  public static function getRelations(): array
  {
    return [OrderProductsRelationManager::class];
  }

  public static function getPages(): array
  {
    return [
      "index" => Pages\ListOrders::route("/"),
      "view" => Pages\ViewOrder::route("/{record}/view"),
    ];
  }
}
