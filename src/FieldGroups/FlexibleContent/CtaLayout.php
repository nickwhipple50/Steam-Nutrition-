<?php

namespace MMM\FieldGroups\FlexibleContent;

use MMM\FieldGroups\Partials\ContentPartial;

class CtaLayout extends BaseLayout
{
  public function getName(): string
  {
    return 'cta';
  }

  protected function getLabel(): string
  {
    return 'Call to Action';
  }

  protected function addFields(): void
  {
    $this->fields
      ->addFields(ContentPartial::get())
      ->addSelect('alignment', [
        'choices' => [
          'left' => 'Left',
          'center' => 'Center'
        ],
        'default_value' => 'center'
      ]);
  }
}