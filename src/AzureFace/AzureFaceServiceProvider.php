<?php
namespace AzureFace;

use Illuminate\Support\ServiceProvider;

class AzureFaceServiceProvider extends ServiceProvider {

  /**
   * Bootstrap the application events.
   *
   * @return void
   */
  public function boot()
  {
      $this->publishes([__DIR__ . '/config/config.php' => config_path('azure-face.php')], 'azure-face');
  }

  /**
   * Register the service provider.
   *
   * @return void
   */
  public function register()
  {
      $this->mergeConfigFrom(__DIR__ . '/config/config.php', 'azure-face');
      $this->mergeConfigFrom(__DIR__ . '/config/speech.php', 'azure-speech');

      $this->app->singleton('niraj-shah.laravel-azure-face-api', function ($app) {
          return new AzureFaceClient(
            $app['config']->get('azure-face.api_key'),
            $app['config']->get('azure-face.endpoint')
          );
      });

      $this->app->singleton('niraj-shah.laravel-azure-speech-api', function ($app) {
          return new AzureSpeechClient(
            $app['config']->get('azure-speech.api_key'),
            $app['config']->get('azure-speech.region')
          );
      });
  }

  /**
  * Get the services provided by the provider.
  *
  * @return array
  */
  public function provides()
  {
      return ['niraj-shah.laravel-azure-face-api', 'niraj-shah.laravel-azure-speech-api'];
  }

}
