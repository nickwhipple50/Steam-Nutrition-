<?php

namespace MMM\Models;

use MMM\Services\FlexibleContentRegistryService;
use Timber\Post as TimberPost;

class Post extends TimberPost {
  /**
   * Get components with their view paths.
   * @return array
   */
  public function components(): array
  {
    $service = FlexibleContentRegistryService::getInstance();
    $components = ($this->fields()['components'] ?? []);

    return array_values( array_map( function ( $component ) use ( $service ) {
      return [
        'layout' => $component['acf_fc_layout'] ?? null,
        'view' => $service->getViewForLayout( $component['acf_fc_layout'] ?? '' ),
        'fields' => $component,
      ];
    }, $components ) );
  }

  /**
   * Get ACF fields for the post.
   * @return array|null
   */
  public function fields(): ?array
  {
    $fields = get_fields( $this->ID );
    return $fields ?: null;
  }
}
