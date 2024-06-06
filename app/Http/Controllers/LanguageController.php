<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;

class LanguageController extends Controller
{
  public function toggleLanguage(string $locale): RedirectResponse
  {
    $availableLocales = config('app.available_locales');
    $locale = array_key_exists($locale, $availableLocales) ? $locale : config('app.fallback_locale');

    App::setLocale($locale);
    Session::put("locale", $locale);

    return redirect()->back();
  }
}
