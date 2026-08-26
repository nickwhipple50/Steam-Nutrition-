<?php

namespace MMM\Controllers\Archives;

use MMM\Controllers\BaseArchiveController;
use MMM\Models\Post;
use Timber\Pagination;
use Timber\PostCollectionInterface;

class PostArchiveController extends BaseArchiveController {
  private ?PostCollectionInterface $posts = null;

  protected function getTemplate(): string
  {
    return 'pages/archive.twig';
  }

  protected function getHeroField(): ?string
  {
    return 'blog_hero';
  }

  protected function noPostsMessage(): string
  {
    return "Sorry, there aren't any posts right now. Check back later.";
  }

  protected function getPagination(): ?Pagination
  {
    return $this->getPosts()->pagination( [
      'mid_size' => 2,
      'end_size' => 1,
      'prev_text' => 'Previous',
      'next_text' => 'Next',
    ] );
  }

  protected function getPosts(): PostCollectionInterface
  {
    if ( $this->posts === null ) {
      $this->posts = Post::archive();
    }

    return $this->posts;
  }

  protected function getExtraContext(): array
  {
    return [
      'archive_type' => 'post',
    ];
  }
}