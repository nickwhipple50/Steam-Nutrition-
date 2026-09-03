<?php

namespace MMM\FieldGroups\FlexibleContent;

use MMM\FieldGroups\Partials\{ContentPartial, MediaSelectorPartial};

class HeroLayout extends BaseLayout
{
  public function getName(): string
  {
    return 'hero';
  }

  protected function getLabel(): string
  {
    return 'Hero';
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
        'label' => 'Hero Height',
        'instructions' => 'Choosing "Media Type: Slider" under Media above turns this into the slideshow hero; "Image" (or a video type) gives the static hero — same layout either way.',
        'choices' => [
          'tall' => 'Tall (70vh)',
          'full' => 'Full Height (100vh)',
        ],
        'default_value' => 'full',
      ])
      ->addTrueFalse('overlay', [
        'label' => 'Darken Background',
        'instructions' => 'Adds a dark scrim over the media so text stays readable',
        'default_value' => 1,
        'ui' => true,
      ])
      ->addTrueFalse('show_filmstrip', [
        'label' => 'Show Thumbnail Filmstrip',
        'instructions' => 'Only applies when Media Type is set to Slider. Shows a clickable row of slide thumbnails below the hero.',
        'default_value' => 1,
        'ui' => true,
      ])
      ->addNumber('slide_duration', [
        'label' => 'Slide Duration (ms)',
        'instructions' => 'Only applies when Media Type is set to Slider.',
        'default_value' => 6000,
      ]);
  }

  protected function getMax(): string
  {
    return '1';
  }
}