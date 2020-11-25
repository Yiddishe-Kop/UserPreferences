<?php

namespace YiddisheKop\UserPreferences;

use Illuminate\Support\ServiceProvider;

class UserPreferencesServiceProvider extends ServiceProvider {
  /**
   * Perform post-registration booting of services.
   *
   * @return void
   */
  public function boot(): void {
    // $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'yiddishekop');
    // $this->loadViewsFrom(__DIR__.'/../resources/views', 'yiddishekop');
    $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');
    // $this->loadRoutesFrom(__DIR__.'/routes.php');

    // Publishing is only necessary when using the CLI.
    if ($this->app->runningInConsole()) {
      $this->bootForConsole();
    }
  }

  /**
   * Register any package services.
   *
   * @return void
   */
  public function register(): void {
    $this->mergeConfigFrom(__DIR__ . '/../config/user-preferences.php', 'user-preferences');

    // Register the service the package provides.
    $this->app->singleton('userPreferences', function ($app) {
      return new UserPreferences;
    });
  }

  /**
   * Get the services provided by the provider.
   *
   * @return array
   */
  public function provides() {
    return ['userPreferences'];
  }

  /**
   * Console-specific booting.
   *
   * @return void
   */
  protected function bootForConsole(): void {
    // Publishing the configuration file.
    $this->publishes([
      __DIR__ . '/../config/user-preferences.php' => config_path('user-preferences.php'),
    ], 'config');

    // Registering package commands.
    // $this->commands([]);
  }
}
