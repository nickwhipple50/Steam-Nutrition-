<?php

namespace MMM\FieldGroups\FlexibleContent;

use MMM\FieldGroups\Partials\ContentPartial;

class CtaTilesLayout extends BaseLayout
{
  public function getName(): string
  {
    return 'cta-tiles';
  }

  protected function getLabel(): string
  {
    return 'CTA Tiles';
  }

  protected function addFields(): void
  {
    $this->fields
      ->addTab('Content')
      ->addFields(ContentPartial::get())
      ->addTab('Tiles')
      ->addRepeater('tiles', [
        'button_label' => 'Add Tile',
        'min' => 1,
        'max' => 4,
      ])
      ->addImage('image', [
        'required' => true,
        'instructions' => 'Background image for the tile',
      ])
      ->addText('title', [
        'required' => true,
        'instructions' => 'e.g. "Supplements"',
      ])
      ->addLink('link', [
        'required' => true,
        'instructions' => 'e.g. "Shop Now" — shown below the title',
      ])
      ->endRepeater();
  }
}