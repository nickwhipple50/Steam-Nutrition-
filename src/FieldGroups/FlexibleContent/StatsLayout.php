<?php

namespace MMM\FieldGroups\FlexibleContent;

use MMM\FieldGroups\Partials\ContentPartial;

class StatsLayout extends BaseLayout
{
  public function getName(): string
  {
    return 'stats';
  }

  protected function getLabel(): string
  {
    return 'Stats';
  }

  protected function addFields(): void
  {
    $this->fields
      ->addTab('Content')
      ->addFields(ContentPartial::get())
      ->addRepeater('stats', [
        'layout' => 'row',
        'button_label' => 'Add Stat'
      ])
      ->addText('number', ['required' => true])
      ->addText('suffix')
      ->addText('label', ['required' => true])
      ->endRepeater();
  }
}