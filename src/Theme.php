<?php

namespace MMM;

use MMM\OptionsPages\ThemeOptions;
use MMM\FieldGroups\{PageContent, SeoFields, ThemeOptionsFields};
use MMM\Models\Post;
use MMM\Services\{FieldGroupRegistryService,
  ImageOptimizationService,
  LaunchChecklistService,
  OptionsPageRegistryService,
  PostTypeRegistryService,
  TaxonomyRegistryService,
  TwigFilterService,
  ViteService};
use MMM\Setup\Security;
use MMM\Traits\Singleton;
use Timber\{Site, Timber};

class Theme
{
  use Singleton;

  private Security $security;
  private TwigFilterService $twigFilterService;

  /**
   * Initialize key theme supports and nav menus.
   * @return void
   */
  public function setup(): void
  {
    add_theme_support('post-thumbnails');

    register_nav_menus([
      'primary' => __('Primary Menu'),
      'footer_shop' => __('Footer — Shop Column'),
      'footer_company' => __('Footer — Company Column'),
      'footer_legal' => __('Footer — Legal Links (sub-footer)'),
    ]);
  }

  /**
   * Add models to the Timber classmap.
   * For use in the `timber/post/classmap` hook.
   * @param array $classmap
   * @return array
   */
  public function classmap(array $classmap): array
  {
    $classmap['post'] = Post::class;
    $classmap['page'] = Post::class;

    return $classmap;
  }

  /**
   * Add site data to Timber context.
   * @param array $context
   * @return array
   */
  public function addToContext(array $context): array
  {
    $context['site'] = new Site();
    $context['menu'] = Timber::get_menu('primary');
    $context['footer_shop_menu'] = Timber::get_menu('footer_shop');
    $context['footer_company_menu'] = Timber::get_menu('footer_company');
    $context['footer_legal_menu'] = Timber::get_menu('footer_legal');
    $context['analytics'] = get_field('analytics', 'option');
    $context['theme_options'] = get_fields('option') ?: [];

    if (function_exists('WC') && WC()->cart) {
      $context['cart_url'] = wc_get_cart_url();
      $context['cart_count'] = WC()->cart->get_cart_contents_count();
      $context['account_url'] = get_permalink(wc_get_page_id('myaccount')) ?: null;
    } else {
      $context['cart_url'] = null;
      $context['cart_count'] = 0;
      $context['account_url'] = null;
    }

    return $context;
  }

  /**
   * Add "has-hero" to the body when the page's first flexible content
   * component is the Hero layout, so the hero can sit full-bleed behind
   * the transparent header instead of below it (see layout/_header.scss).
   * @param array $classes
   * @return array
   */
  public function bodyClass(array $classes): array
  {
    if (!is_page()) {
      return $classes;
    }

    $postId = get_queried_object_id();
    $fields = $postId ? get_fields($postId) : null;
    $components = $fields['components'] ?? [];
    $first = $components[0] ?? null;

    if (($first['acf_fc_layout'] ?? null) === 'hero') {
      $classes[] = 'has-hero';
    }

    return $classes;
  }

  private function init(): void
  {
    // Set Timber directory
    Timber::$dirname = ['views'];

    // Enqueue assets
    $this->enqueue();

    // Add WordPress security
    Security::getInstance();

    // Add extra Twig filters
    TwigFilterService::getInstance();

    // Add launch checklist
    LaunchChecklistService::getInstance();

    // Instantiate image optimization service
    ImageOptimizationService::getInstance();

    // Register hooks
    add_action('after_setup_theme', [$this, 'setup']);
    add_filter('use_block_editor_for_post_type', '__return_false');

    // Register Timber necessities
    add_filter('timber/context', [$this, 'addToContext']);
    add_filter('timber/post/classmap', [$this, 'classmap']);

    // Let the hero layout sit full-bleed behind the transparent header
    add_filter('body_class', [$this, 'bodyClass']);

    $this->registerPostTypes();
    $this->registerTaxonomies();
    $this->registerOptionsPages();
    $this->registerFieldGroups();
  }

  /**
   * Enqueue assets using the ViteService.
   * @return void
   */
  private function enqueue(): void
  {
    $vite = ViteService::getInstance();
    $vite->enqueue('mmm-main', 'main');
  }

  /**
   * Register ACF field groups using the FieldGroupRegistryService.
   * @return void
   */
  private function registerFieldGroups(): void
  {
    $fieldsRegistry = FieldGroupRegistryService::getInstance();

    // Add field groups here
    $fieldsRegistry->register(SeoFields::class);
    $fieldsRegistry->register(PageContent::class);
    $fieldsRegistry->register(ThemeOptionsFields::class);

    $fieldsRegistry->boot();
  }

  /**
   * Register post types using the PostTypeRegistryService.
   * @return void
   */
  private function registerPostTypes(): void
  {
    $postTypeRegistry = PostTypeRegistryService::getInstance();

    // $postTypeRegistry->register(BasePostType::class);
  }

  /**
   * Register custom taxonomies using the TaxonomyRegistryService.
   * @return void
   */
  private function registerTaxonomies(): void
  {
    $taxonomyRegistry = TaxonomyRegistryService::getInstance();

    // $taxonomyRegistry->register(BaseTaxonomy::class);
  }

  /**
   * Register options pages using the OptionsPageRegistryService.
   * @return void
   */
  private function registerOptionsPages(): void
  {
    $optionsPageRegistry = OptionsPageRegistryService::getInstance();

    $optionsPageRegistry->register(ThemeOptions::class);
  }
}