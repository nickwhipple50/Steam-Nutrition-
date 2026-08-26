<?php

namespace MMM\Services;

use InvalidArgumentException;
use MMM\OptionsPages\BaseOptionsPage;
use MMM\Traits\Singleton;

class OptionsPageRegistryService {
  use Singleton;

  private array $optionsPages = [];

  public function init(): void
  {
    add_action( 'acf/init', [ $this, 'registerAll' ] );
  }

  public function registerAll(): void
  {
    foreach ( $this->optionsPages as $optionsPageClass ) {
      $optionsPage = new $optionsPageClass();
      $optionsPage->register();
    }
  }

  public function register( string $optionsPageClass ): void
  {
    if ( !is_subclass_of( $optionsPageClass, BaseOptionsPage::class ) ) {
      throw new InvalidArgumentException(
        "$optionsPageClass is not a subclass of BaseOptionsPage"
      );
    }

    $this->optionsPages[] = $optionsPageClass;
  }
}