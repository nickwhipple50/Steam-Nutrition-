<?php

namespace MMM\Controllers\Single;

use MMM\Controllers\BaseController;
use Timber\Timber;

class PostController extends BaseController {
  public function render(): void
  {
    $this->renderView(
      'pages/single.twig',
      [
        'post' => Timber::get_post( get_the_ID() ),
      ]
    );
  }
}