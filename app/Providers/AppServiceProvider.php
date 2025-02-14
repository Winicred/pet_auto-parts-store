<?php

namespace App\Providers;

use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\App;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
  /**
   * Register any application services.
   */
  public function register(): void
  {
    //
  }

  /**
   * Bootstrap any application services.
   */
  public function boot(): void
  {
    view()->composer("partials.language-switcher", function ($view) {
      $view->with("current_locale", App::getLocale());
      $view->with("available_locales", config("app.available_locales"));
    });

    Paginator::useTailwind();
  }
}
