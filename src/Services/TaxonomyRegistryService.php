<?php

namespace MMM\Services;

use MMM\Taxonomies\BaseTaxonomy;
use MMM\Traits\Singleton;

class TaxonomyRegistryService
{
  use Singleton;

  /** @var class-string<BaseTaxonomy>[] */
  private array $taxonomies = [];

  protected function init(): void
  {
    add_action('init', [$this, 'registerTaxonomies']);
  }

  public function register(string $taxonomyClass): void
  {
    if (!is_subclass_of($taxonomyClass, BaseTaxonomy::class)) {
      throw new \InvalidArgumentException(
        "{$taxonomyClass} must extend BaseTaxonomy"
      );
    }

    $this->taxonomies[] = $taxonomyClass;
  }

  public function registerTaxonomies(): void
  {
    foreach ($this->taxonomies as $taxonomyClass) {
      $taxonomyClass::register();
    }
  }
}