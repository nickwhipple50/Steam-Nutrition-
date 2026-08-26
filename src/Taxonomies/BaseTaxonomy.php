<?php

namespace MMM\Taxonomies;

abstract class BaseTaxonomy
{
  abstract protected static function slug(): string;

  abstract protected static function singular(): string;

  abstract protected static function plural(): string;

  /**
   * Post type slugs this taxonomy should be attached to
   * @return string[]
   */
  abstract protected static function postTypes(): array;

  protected static function additionalArgs(): array
  {
    return [];
  }

  final public static function register(): void
  {
    register_taxonomy(
      static::slug(),
      static::postTypes(),
      static::args()
    );
  }

  protected static function args(): array
  {
    return array_merge([
      'labels' => static::labels(),
      'public' => true,
      'show_in_rest' => true,
      'hierarchical' => false,
    ], static::additionalArgs());
  }

  protected static function labels(): array
  {
    $singular = static::singular();
    $plural = static::plural();

    return [
      'name' => __($plural, 'athena'),
      'singular_name' => __($singular, 'athena'),
      'menu_name' => __($plural, 'athena'),
      'all_items' => sprintf(__('All %s', 'athena'), $plural),
      'add_new_item' => sprintf(__('Add New %s', 'athena'), $singular),
      'edit_item' => sprintf(__('Edit %s', 'athena'), $singular),
      'view_item' => sprintf(__('View %s', 'athena'), $singular),
      'search_items' => sprintf(__('Search %s', 'athena'), $plural),
      'not_found' => sprintf(__('No %s found', 'athena'), strtolower($plural)),
      'no_terms' => sprintf(__('No %s', 'athena'), strtolower($plural)),
      'items_list_navigation' => sprintf(__('%s list navigation', 'athena'), $plural),
      'items_list' => sprintf(__('%s list', 'athena'), $plural),
    ];
  }
}