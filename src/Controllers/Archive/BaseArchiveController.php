<?php

namespace MMM\Controllers;

use Timber\Pagination;
use WP_Post_Type;
use WP_Term;

abstract class BaseArchiveController extends BaseController {
  public function render(): void
  {
    $this->renderView(
      $this->getTemplate(),
      array_merge(
        [
          'posts'         => $this->getPosts(),
          'pagination'    => $this->getPagination(),
          'archive'       => $this->getArchiveObject(),
          'empty_message' => $this->noPostsMessage(),
          'title'         => $this->getTitle(),
          'description'   => $this->getDescription(),
          'seo'           => $this->getSeo(),
        ],
        $this->getHeroField() ? [ 'hero' => get_field( $this->getHeroField(), 'option' ) ] : [],
        $this->getExtraContext()
      )
    );
  }

  abstract protected function getTemplate(): string;

  abstract protected function getPosts();

  protected function noPostsMessage(): string {
    return "Sorry, we didn't find any content of that type. Try again later.";
  }

  protected function getPagination(): ?Pagination
  {
    return null;
  }

  protected function getArchiveObject(): WP_Post_Type|WP_Term|null
  {
    $object = get_queried_object();

    return $object instanceof WP_Post_Type || $object instanceof WP_Term
      ? $object
      : null;
  }

  protected function getTitle(): string
  {
    return post_type_archive_title( '', false ) ?: wp_get_document_title();
  }

  protected function getDescription(): ?string
  {
    $description = get_the_archive_description();
    return $description ?: null;
  }

  protected function getSeo(): array
  {
    $object = $this->getArchiveObject();
    $canonical = $object instanceof WP_Post_Type
      ? get_post_type_archive_link( $object->name )
      : ( $object instanceof WP_Term ? get_term_link( $object ) : get_bloginfo( 'url' ) );

    return [
      'title'       => wp_get_document_title(),
      'description' => get_the_archive_description() ?: '',
      'canonical'   => $canonical ?: get_bloginfo( 'url' ),
    ];
  }

  protected function getHeroField(): ?string
  {
    return null;
  }

  protected function getExtraContext(): array
  {
    return [];
  }
}