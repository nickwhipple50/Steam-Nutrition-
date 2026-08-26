<?php

namespace MMM\OptionsPages;

use ReflectionClass;

abstract class BaseOptionsPage {
  public function register(): void
  {
    if ( function_exists( 'acf_add_options_page' ) ) {
      acf_add_options_page( [
        'page_title' => $this->getTitle(),
        'menu_title' => $this->getMenuTitle(),
        'menu_slug' => $this->getSlug(),
        'capability' => $this->getCapability(),
        'icon_url' => $this->getIcon(),
        'position' => $this->getPosition(),
        'redirect' => true,
      ] );
    }
  }

  abstract protected function getTitle(): string;

  protected function getMenuTitle(): string
  {
    return $this->getTitle();
  }

  public function getSlug(): string
  {
    $className = (new ReflectionClass( $this ))->getShortName();
    return strtolower( preg_replace( '/(?<!^)[A-Z]/', '-$0', $className ) );
  }

  protected function getCapability(): string
  {
    return 'edit_posts';
  }

  protected function getIcon(): string
  {
    return '';
  }

  protected function getPosition(): ?int
  {
    return null;
  }

  public function registerSubPage( BaseOptionsPage $parent ): void
  {
    if ( function_exists( 'acf_add_options_sub_page' ) ) {
      acf_add_options_sub_page( [
        'page_title' => $this->getTitle(),
        'menu_title' => $this->getMenuTitle(),
        'menu_slug' => $this->getSlug(),
        'capability' => $this->getCapability(),
        'parent_slug' => $parent->getSlug(),
        'redirect' => false,
      ] );
    }
  }
}