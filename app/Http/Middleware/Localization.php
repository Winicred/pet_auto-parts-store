<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request as RequestAlias;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class Localization
{

  /**
   * Handle an incoming request.
   *
   * @param RequestAlias $request
   * @param Closure $next
   * @return Response|RedirectResponse|JsonResponse|BinaryFileResponse
   */
  public function handle(RequestAlias $request, Closure $next): Response|RedirectResponse|JsonResponse|BinaryFileResponse
  {
    if (str_contains($request->url(), "admin")) {
      App::setLocale("en");
      $cookie = cookie('locale', 'en', 60 * 24 * 30);
    } else if ($request->hasHeader('X-localization')) {
      $locale = $request->header('X-localization', config('app.fallback_locale'));

      App::setLocale($locale);
      $cookie = cookie('locale', $locale, 60 * 24 * 30);
    } else {
      $locale = Session::get("locale", config('app.fallback_locale'));

      App::setLocale($locale);
      $cookie = cookie('locale', $locale, 60 * 24 * 30);
    }

//    dd($request->url(), $locale, $cookie, $request->hasHeader('X-localization'), App::getLocale(), Session::get("locale"));

    $response = $next($request);
    if ($response instanceof BinaryFileResponse) {
      return $response;
    }

    return $response->withCookie($cookie);
  }
}
