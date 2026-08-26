<?php

namespace MMM\Queries;

use Timber\{PostCollectionInterface, Timber};

class PostQuery {
  public static function archive( array $args = [] ): PostCollectionInterface {
    return Timber::get_posts(array_merge([
      'post_type' => 'post',
      'post_status' => 'publish',
      'posts_per_page' => get_option( 'posts_per_page' ),
      'paged' => get_query_var( 'paged' ) ?: 1,
    ], $args));
  }
}