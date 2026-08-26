<?php

namespace MMM;

use MMM\OptionsPages\ThemeOptions;
use MMM\FieldGroups\{PageContent, SeoFields, ThemeOptionsFields};
use MMM\Models\Post;
use MMM\Services\{FieldGroupRegistryService,
  ImageOptimizationService,
  LaunchChecklistService,
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
    $context['analytics'] = get_field('analytics', 'option');

    return $context;
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
   * Register custom taxonomies using the TaxonomyRegistryService.
   * @return void
   */
  private function registerOptionsPages(): void
  {
    $optionsPageRegistryRegistry = TaxonomyRegistryService::getInstance();

    $optionsPageRegistryRegistry->register(ThemeOptions::class);
  }
}