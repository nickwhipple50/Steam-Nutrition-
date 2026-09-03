<?php

namespace MMM\Queries;

use WP_Post;
use WP_Query;

class ProductQuery
{
  /**
   * Pull published, in-stock products from a single WooCommerce category.
   * @param int $termId product_cat term ID
   * @param int $count Max number of products to return
   * @param string $orderBy One of: date, popularity, price, title, rand
   * @param string $order ASC or DESC
   * @return array<int, array>
   */
  public static function byCategory(
    int $termId,
    int $count = 8,
    string $orderBy = 'date',
    string $order = 'DESC'
  ): array {
    if (!$termId || !function_exists('wc_get_product')) {
      return [];
    }

    $order = strtoupper($order) === 'ASC' ? 'ASC' : 'DESC';

    $queryArgs = [
      'post_type' => 'product',
      'post_status' => 'publish',
      'posts_per_page' => max(1, $count),
      'order' => $order,
      'no_found_rows' => true,
      'tax_query' => [[
        'taxonomy' => 'product_cat',
        'field' => 'term_id',
        'terms' => $termId,
      ]],
    ];

    switch ($orderBy) {
      case 'popularity':
        $queryArgs['meta_key'] = 'total_sales';
        $queryArgs['orderby'] = 'meta_value_num';
        break;
      case 'price':
        $queryArgs['meta_key'] = '_price';
        $queryArgs['orderby'] = 'meta_value_num';
        break;
      case 'title':
        $queryArgs['orderby'] = 'title';
        break;
      case 'rand':
        $queryArgs['orderby'] = 'rand';
        break;
      default:
        $queryArgs['orderby'] = 'date';
    }

    $query = new WP_Query($queryArgs);

    return array_values(array_filter(array_map(
      [self::class, 'toArray'],
      $query->posts
    )));
  }

  /**
   * Shape a single product into the plain array the Twig view expects.
   * @param WP_Post $post
   * @return array|null
   */
  private static function toArray(WP_Post $post): ?array
  {
    $product = wc_get_product($post->ID);

    if (!$product) {
      return null;
    }

    $imageId = $product->get_image_id();
    $imageUrl = $imageId ? wp_get_attachment_image_url($imageId, 'medium') : '';

    return [
      'id' => $product->get_id(),
      'title' => $product->get_name(),
      'permalink' => get_permalink($product->get_id()),
      'price_html' => $product->get_price_html(),
      'on_sale' => $product->is_on_sale(),
      'purchasable' => $product->is_purchasable() && $product->is_in_stock(),
      'add_to_cart_url' => $product->add_to_cart_url(),
      'image' => [
        'url' => $imageUrl ?: (function_exists('wc_placeholder_img_src') ? wc_placeholder_img_src() : ''),
        'alt' => $imageId ? (get_post_meta($imageId, '_wp_attachment_image_alt', true) ?: $product->get_name()) : $product->get_name(),
      ],
    ];
  }
}