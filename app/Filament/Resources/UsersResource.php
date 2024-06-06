<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UsersResource\Pages;
use App\Models\User;
use Carbon\Carbon;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;
use Ramsey\Uuid\Uuid;

class UsersResource extends Resource
{
  protected static ?string $model = User::class;
  protected static ?string $navigationGroup = "Users";
  protected static ?string $navigationIcon = 'heroicon-o-user-group';

  public static function getNavigationBadge(): ?string
  {
    return static::getModel()::count();
  }

  public static function canViewAny(): bool
  {
    return auth()->user()->isAdmin();
  }

  public static function getRecords(): Builder
  {
    return static::getModel()::query()->where('id', '!=', auth()->id());
  }

  public static function getGloballySearchableAttributes(): array
  {
    return [
      'name',
      'email',
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
      'Email' => $record->email,
    ];
  }

  public static function form(Form $form): Form
  {
    return $form
      ->schema([
        TextInput::make('name')
          ->label('Username')
          ->placeholder('Username')
          ->disabled(fn($record) => $record?->id === auth()->id())
          ->unique(User::class, 'name', ignorable: fn($record) => $record)
          ->maxLength(100)
          ->required(),
        TextInput::make('email')
          ->label('Email')
          ->placeholder('Email')
          ->disabled(fn($record) => $record?->id === auth()->id())
          ->unique(User::class, 'email', ignorable: fn($record) => $record)
          ->email()
          ->maxLength(100)
          ->required(),
        TextInput::make('password')
          ->label('Password')
          ->placeholder('Password')
          ->password()
          ->dehydrateStateUsing(fn($state) => Hash::make($state))
          ->maxLength(32)
          ->visibleOn('create')
          ->required(),
        TextInput::make('password_confirmation')
          ->label('Password Confirmation')
          ->placeholder('Password Confirmation')
          ->password()
          ->same('password')
          ->maxLength(32)
          ->visibleOn('create')
          ->required(),
        FileUpload::make('avatar')
          ->label('Avatar')
          ->image()
          ->maxSize(1024 * 1024 * 5)
          ->hint('Max file size 5MB')
          ->disk('users_images')
          ->dehydrateStateUsing(fn($state) => !empty($state) ? array_values($state)[0] : "default.png")
          ->getUploadedFileNameForStorageUsing(fn(TemporaryUploadedFile $file): string => Uuid::uuid4() . "." . $file->getClientOriginalExtension()),
        Select::make('role')
          ->label('Role')
          ->placeholder('Select Role')
          ->searchable()
          ->disabled(fn($record) => $record?->id === auth()->id())
          ->options([
            'admin' => 'Admin',
            'manager' => 'Manager',
            'user' => 'User',
          ])
          ->required(),
        TextInput::make('firstName')
          ->label('First Name')
          ->placeholder('First Name'),
        TextInput::make('lastName')
          ->label('Last Name')
          ->placeholder('Last Name'),
        TextInput::make('phone')
          ->label('Phone')
          ->placeholder('Phone')
          ->maxLength(100)
          ->tel()
          ->telRegex('/^[+]*[(]{0,1}[0-9]{1,4}[)]{0,1}[-\s\.\/0-9]*$/'),
        Select::make('country')
          ->label('Country')
          ->placeholder('Select Country')
          ->searchable()
          ->options(function () {
            $countries = config('stripe.available_countries');
            $translatedCountries = [];

            foreach ($countries as $key => $language) {
              $translatedCountries[] = [$key + 1 => __('countries.' . $language)];
            }

            return array_merge(...$translatedCountries);
          }),
        TextInput::make('city')
          ->label('City')
          ->placeholder('City')
          ->maxLength(100),
        TextInput::make('address')
          ->label('Address')
          ->placeholder('Address')
          ->maxLength(100),
        TextInput::make('zipCode')
          ->label('Zip Code')
          ->placeholder('Zip Code')
          ->maxLength(100),
        TextInput::make('state')
          ->label('State')
          ->placeholder('State')
          ->maxLength(100),
      ]);
  }

  public static function table(Table $table): Table
  {
    return $table
      ->columns([
        TextColumn::make('name')
          ->sortable()
          ->weight('bold')
          ->searchable(),
        TextColumn::make('email')
          ->sortable()
          ->searchable(),
        TextColumn::make('role')
          ->sortable()
          ->searchable(),
        TextColumn::make('stripe_id')
          ->sortable()
          ->badge()
          ->label("Stripe ID")
          ->icon(function ($record) {
            return $record->stripe_id ? 'heroicon-o-check' : 'heroicon-o-x-mark';
          })
          ->color(function ($record) {
            return $record->stripe_id ? 'success' : 'danger';
          })
          ->getStateUsing(fn($record) => $record->stripe_id ? 'Exist' : 'Not Exist')
          ->searchable(),
        TextColumn::make('createdAt')
          ->sortable()
          ->formatStateUsing(function ($record) {
            return Carbon::parse($record->createdAt)->format('H:i d/m/Y');
          })
          ->searchable(),
      ])
      ->filters([
        SelectFilter::make('role')
          ->label('Role')
          ->options(['admin' => 'Admin', 'manager' => 'Manager', 'user' => 'User']),
        SelectFilter::make('stripe_id')
          ->label('Stripe ID')
          ->options(['true' => 'Exist', 'false' => 'Not Exist'])
          ->query(function (Builder $query, array $data) {
            if (empty($data["value"])) {
              return $query->get();
            }

            return $query->where('stripe_id', $data["value"] === 'true' ? '!=' : '=', null)->get();
          }),
      ])
      ->actions([
        EditAction::make(),
        DeleteAction::make()->disabled(fn($record) => $record?->id === auth()->id()),
      ])
      ->bulkActions([
        DeleteBulkAction::make(),
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
      'index' => Pages\ListUsers::route('/'),
      'create' => Pages\CreateUsers::route('/create'),
      'edit' => Pages\EditUsers::route('/{record}/edit'),
    ];
  }
}
