<?php

namespace MMM\FieldGroups\FlexibleContent;

use MMM\FieldGroups\Partials\{ContentPartial, MediaSelectorPartial};

class CampaignBannerLayout extends BaseLayout
{
  public function getName(): string
  {
    return 'campaign-banner';
  }

  protected function getLabel(): string
  {
    return 'Campaign Banner';
  }

  protected function addFields(): void
  {
    $this->fields
      ->addTab('Content')
      ->addSelect('alignment', [
        'label' => 'Text Alignment',
        'choices' => [
          'left' => 'Left',
          'center' => 'Center',
          'right' => 'Right',
        ],
        'default_value' => 'left',
      ])
      ->addFields(ContentPartial::get())
      ->addTab('Media')
      ->addFields(MediaSelectorPartial::get())
      ->addSelect('height', [
        'label' => 'Banner Height',
        'choices' => [
          'auto' => 'Auto (fits content)',
          'tall' => 'Tall',
          'full' => 'Full Height',
        ],
        'default_value' => 'tall',
      ])
      ->addTrueFalse('overlay', [
        'label' => 'Darken Background',
        'instructions' => 'Adds a dark scrim over the media so text stays readable',
        'default_value' => 1,
        'ui' => true,
      ]);
  }
}