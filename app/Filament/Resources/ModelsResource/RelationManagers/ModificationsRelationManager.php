<?php

namespace App\Filament\Resources\ModelsResource\RelationManagers;

use App\Models\BodyType;
use App\Models\ModelModification;
use Filament\Forms\Components\DatePicker;
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
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;

class ModificationsRelationManager extends RelationManager
{
  protected static string $relationship = 'modifications';

  protected static ?string $recordTitleAttribute = 'modelId';

  public function form(Form $form): Form
  {
    return $form
      ->schema([
        Select::make("bodyId")
          ->relationship("body", "bodyId")
          ->required()
          ->searchable()
          ->label("Car Body Type")
          ->validationAttribute("body")
          ->placeholder("Select a Car Body Type")
          ->getSearchResultsUsing(function (string $search) {
            return BodyType::where("enName", "like", "%{$search}%")
              ->get()
              ->mapWithKeys(function ($body) {
                return [$body->id => $body->enName];
              });
          })
          ->options(function () {
            return BodyType::orderBy("enName", "asc")->get()->mapWithKeys(function ($body) {
              return [$body->id => $body->enName];
            });
          }),
        TextInput::make("engineCode")
          ->required()
          ->dehydrateStateUsing(fn($state) => Str::upper($state))
          ->label("Engine Code")
          ->placeholder("Engine Code"),
        TextInput::make("engineCapacity")
          ->required()
          ->mask(RawJs::make('function (value) { return value.replace(/[^0-9.]/g, ""); }'))
          ->label("Engine Capacity")
          ->placeholder("Engine Capacity")
          ->hint("Engine Capacity in cc"),
        Select::make("engineFuel")
          ->required()
          ->label("Engine Fuel")
          ->placeholder("Select Engine Fuel")
          ->options([
            "petrol" => "Petrol",
            "diesel" => "Diesel",
            "hybrid" => "Hybrid",
            "electric" => "Electric",
            'gas' => 'Gas',
          ]),
        Select::make("transmissionType")
          ->required()
          ->label("Transmission Type")
          ->placeholder("Select Transmission Type")
          ->options([
            "automatic" => "Automatic",
            "manual" => "Manual",
            "robotic" => "Robotic",
            "variator" => "Variator",
          ]),
        Select::make("transmissionDrive")
          ->required()
          ->label("Transmission Drive")
          ->placeholder("Select Transmission Drive")
          ->options([
            "front" => "Front Wheel",
            "rear" => "Rear Wheel",
            "full" => "All Wheel",
          ]),
        TextInput::make("enginePower")
          ->label("Engine Power")
          ->placeholder("Engine Power")
          ->mask(RawJs::make('function (value) { return value.replace(/[^0-9]/g, ""); }'))
          ->hint("Engine Power in hp"),
        TextInput::make("engineTorque")
          ->label("Engine Torque")
          ->mask(RawJs::make('function (value) { return value.replace(/[^0-9]/g, ""); }'))
          ->placeholder("Engine Torque")
          ->hint("Engine Torque in Nm"),
        TextInput::make("engineFuelConsumptionCity")
          ->label("Engine Fuel Consumption City")
          ->mask(RawJs::make('function (value) { return value.replace(/[^0-9.]/g, ""); }'))
          ->placeholder("Engine Fuel Consumption City")
          ->hint("Engine Fuel Consumption City in l/100km"),
        TextInput::make("engineFuelConsumptionHighway")
          ->label("Engine Fuel Consumption Highway")
          ->mask(RawJs::make('function (value) { return value.replace(/[^0-9.]/g, ""); }'))
          ->placeholder("Engine Fuel Consumption Highway")
          ->hint("Engine Fuel Consumption Highway in l/100km"),
        TextInput::make("engineFuelConsumptionCombined")
          ->label("Engine Fuel Consumption Combined")
          ->mask(RawJs::make('function (value) { return value.replace(/[^0-9.]/g, ""); }'))
          ->placeholder("Engine Fuel Consumption Combined")
          ->hint("Engine Fuel Consumption Combined in l/100km"),
        Select::make("engineInjectionType")
          ->label("Engine Injection Type")
          ->placeholder("Select Engine Injection Type")
          ->options([
            "mpfi" => "MPFI",
            "throttleBody" => "Throttle Body",
            "multiPointInjection" => "Multi Point Injection",
            "directInjection" => "Direct Injection",
            "portInjection" => "Port Injection",
            "sequentialInjection" => "Sequential Injection",
            "commonRailInjection" => "Common Rail Injection",
            "dieselInjection" => "Diesel Injection",
            "hybridInjection" => "Hybrid Injection",
            "electricInjection" => "Electric Injection",
          ]),
        TextInput::make("engineCylinderCount")
          ->label("Engine Cylinders Count")
          ->mask(RawJs::make('function (value) { return value.replace(/[^0-9.]/g, ""); }'))
          ->placeholder("Engine Cylinders Count"),
        TextInput::make("engineValveCount")
          ->label("Engine Valves Count")
          ->mask(RawJs::make('function (value) { return value.replace(/[^0-9.]/g, ""); }'))
          ->placeholder("Engine Valves Count"),
        TextInput::make("transmissionGearCount")
          ->label("Transmission Gear Count")
          ->mask(RawJs::make('function (value) { return value.replace(/[^0-9.]/g, ""); }'))
          ->placeholder("Transmission Gear Count"),
        TextInput::make("weight")
          ->label("Weight")
          ->mask(RawJs::make('function (value) { return value.replace(/[^0-9.]/g, ""); }'))
          ->placeholder("Weight")
          ->hint("Weight in kg"),
        TextInput::make("clearance")
          ->label("Clearance")
          ->mask(RawJs::make('function (value) { return value.replace(/[^0-9.]/g, ""); }'))
          ->placeholder("Clearance")
          ->hint("Clearance in mm"),
        TextInput::make("fuelTankCapacity")
          ->label("Fuel Tank Capacity")
          ->mask(RawJs::make('function (value) { return value.replace(/[^0-9.]/g, ""); }'))
          ->placeholder("Fuel Tank Capacity")
          ->hint("Fuel Tank Capacity in l"),
        TextInput::make("seatsCount")
          ->label("Seats Count")
          ->mask(RawJs::make('function (value) { return value.replace(/[^0-9.]/g, ""); }'))
          ->placeholder("Seats Count"),
        TextInput::make("trunkCapacity")
          ->label("Trunk Capacity")
          ->mask(RawJs::make('function (value) { return value.replace(/[^0-9.]/g, ""); }'))
          ->placeholder("Trunk Capacity")
          ->hint("Trunk Capacity in l"),
        TextInput::make("doorsCount")
          ->label("Doors Count")
          ->mask(RawJs::make('function (value) { return value.replace(/[^0-9.]/g, ""); }'))
          ->placeholder("Doors Count"),
        DatePicker::make("releasedAt")
          ->required()
          ->label("Production Start Date")
          ->format("m.Y")
          ->displayFormat("m.Y")
          ->minDate(now()->subYears(75))
          ->maxDate(now())
          ->default(now())
          ->placeholder('Enter a year e.g. "03.2018"'),
        DatePicker::make("stoppedAt")
          ->label("Production End Date")
          ->format("m.Y")
          ->displayFormat("m.Y")
          ->minDate(now()->subYears(75))
          ->maxDate(now())
          ->placeholder('Enter a year e.g. "08.2022"'),
      ]);
  }

  public function table(Table $table): Table
  {
    return $table
      ->columns([
        TextColumn::make("id")
          ->label("ID")
          ->sortable(),
        TextColumn::make("engineCode")
          ->label("Engine Code")
          ->sortable(),
        TextColumn::make("engineCapacity")
          ->label("Engine Capacity")
          ->sortable(),
        TextColumn::make("enginePower")
          ->label("Engine Power")
          ->sortable(),
        TextColumn::make("transmissionType")
          ->label("Transmission Type")
          ->sortable(),
        TextColumn::make("transmissionGearCount")
          ->label("Transmission Gear Count")
          ->sortable(),
      ])
      ->filters([
        SelectFilter::make("transmissionType")
          ->label("Transmission Type")
          ->options(ModelModification::distinct()->get()->mapWithKeys(function ($item) {
            return [$item->transmissionType => Str::title($item->transmissionType)];
          })->toArray()),
        SelectFilter::make("engineInjectionType")
          ->label("Engine Injection Type")
          ->placeholder("All")
          ->options(ModelModification::distinct()->get()->mapWithKeys(function ($item) {
            return [$item->engineInjectionType => Str::title($item->engineInjectionType)];
          })->toArray()),
        SelectFilter::make("engineFuel")
          ->label("Engine Fuel Type")
          ->placeholder("All")
          ->options(ModelModification::distinct()->get()->mapWithKeys(function ($item) {
            return [$item->engineFuel => Str::title($item->engineFuel)];
          })->toArray()),
        SelectFilter::make("bodyType")
          ->label("Body Type")
          ->placeholder("All")
          ->options(BodyType::all()->pluck("enName", "id")),
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
      ->headerActions([
        CreateAction::make(),
      ])
      ->actions([
        EditAction::make(),
        DeleteAction::make(),
      ])
      ->bulkActions([
        DeleteBulkAction::make(),
      ]);
  }
}
