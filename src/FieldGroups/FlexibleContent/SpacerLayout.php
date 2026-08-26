<?php

namespace MMM\FieldGroups\FlexibleContent;

class SpacerLayout extends BaseLayout {
  public function getName(): string
  {
    return 'spacer';
  }

  protected function getLabel(): string
  {
    return 'Spacer';
  }

  protected function addFields(): void
  {
    $this->fields
      ->addTab('Spacer Settings')
      ->addSelect( 'height', [
        'choices' => [
          'sm' => 'Small',
          'md' => 'Medium',
          'lg' => 'Large',
          'xl' => 'XL',
        ],
        'default_value' => 'md'
      ] );
  }
}