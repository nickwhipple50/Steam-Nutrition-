<?php

namespace MMM\FieldGroups\FlexibleContent;

use MMM\FieldGroups\Partials\ContentPartial;

class CategoryTilesLayout extends BaseLayout
{
  public function getName(): string
  {
    return 'category-tiles';
  }

  protected function getLabel(): string
  {
    return 'Category Tiles';
  }

  protected function addFields(): void
  {
    $this->fields
      ->addTab('Content')
      ->addFields(ContentPartial::get())
      ->addTab('Tiles')
      ->addSelect('columns', [
        'label' => 'Columns (Desktop)',
        'choices' => [
          '2' => '2',
          '3' => '3',
          '4' => '4',
          '5' => '5',
        ],
        'default_value' => '4',
      ])
      ->addRepeater('tiles', [
        'button_label' => 'Add Tile',
        'min' => 1,
      ])
      ->addImage('image', [
        'required' => true,
        'instructions' => 'Square or portrait images work best',
      ])
      ->addLink('link', [
        'required' => true,
        'instructions' => 'The link title is used as the tile label',
      ])
      ->endRepeater();
  }
}