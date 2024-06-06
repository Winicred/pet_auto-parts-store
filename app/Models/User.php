<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements FilamentUser
{
  use HasFactory, Notifiable;

  public $timestamps = false;

  protected $fillable = ["name", "email", "password", "firstName", "lastName", "phone", "country", "city", "address", "address2", "zipCode", "state", "role", "avatar"];
  protected $hidden = ["password", "remember_token"];

  public function isManager(): bool
  {
    return $this->role === "manager";
  }

  public function isAdmin(): bool
  {
    return $this->role === "admin";
  }

  public function canAccessPanel(Panel $panel): bool
  {
    return $this->isManager() || $this->isAdmin();
  }

  public function canAccessFilament(): bool
  {
    return $this->isManager() || $this->isAdmin();
  }

  public function orders()
  {
    return $this->hasMany(Order::class, "userId");
  }
}
