<?php

namespace MMM\Services;

use MMM\Queries\ProductQuery;
use MMM\Traits\Singleton;
use Twig\{Environment, TwigFilter, TwigFunction};

class TwigFilterService
{
  use Singleton;

  /**
   * Register custom Twig filters.
   * @param Environment $twig
   * @return mixed
   */
  public function registerFilters(Environment $twig): Environment
  {
    $twig->addFilter(new TwigFilter('tel', function (?string $phone): string {
      if (!$phone) {
        return '';
      }
      return preg_replace('/[^0-9+]/', '', $phone);
    }));

    $twig->addFilter(new TwigFilter('obfuscate_email', fn($e) => antispambot($e)));

    $twig->addFilter(new TwigFilter('slugify', function ($text) {
      $text = strtolower($text);
      $text = preg_replace('/[\s_]+/', '-', $text);
      $text = preg_replace('/[^a-z0-9\-]/', '', $text);
      $text = preg_replace('/-+/', '-', $text);
      return trim($text, '-');
    }));

    return $twig;
  }

  /**
   * Register custom Twig functions.
   * @param Environment $twig
   * @return Environment
   */
  public function registerFunctions(Environment $twig): Environment
  {
    $twig->addFunction(new TwigFunction(
      'mmm_products_by_category',
      function (int $termId, int $count = 8, string $orderBy = 'date', string $order = 'DESC'): array {
        return ProductQuery::byCategory($termId, $count, $orderBy, $order);
      }
    ));

    return $twig;
  }

  private function init(): void
  {
    add_filter('timber/twig', [$this, 'registerFilters']);
    add_filter('timber/twig', [$this, 'registerFunctions']);
  }
}