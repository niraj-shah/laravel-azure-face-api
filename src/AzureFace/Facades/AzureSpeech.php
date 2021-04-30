<?php namespace AzureFace\Facades;

use Illuminate\Support\Facades\Facade;

class AzureSpeech extends Facade {

  /**
   * Get the registered name of the component.
   *
   * @return string
   */
  protected static function getFacadeAccessor()
  {
      return 'niraj-shah.laravel-azure-speech-api';
  }

}
