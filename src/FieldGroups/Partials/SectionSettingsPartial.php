<?php

namespace MMM\FieldGroups\Partials;

use StoutLogic\AcfBuilder\FieldsBuilder;

class SectionSettingsPartial extends BasePartial
{
  public static function get(): FieldsBuilder
  {
    $fields = new FieldsBuilder('section_settings');

    $fields->addGroup('section', [
      'label' => 'Section Settings',
    ])
      ->addText('anchor_id',
      [
        'label' => 'Anchor ID',
        'instructions' => 'Optional ID for anchor links (do not include #)',
      ])
      ->addSelect('semantic_element', [
        'label' => 'HTML Element',
        'choices' => [
          'section' => 'Section',
          'div'     => 'Div',
          'aside'   => 'Aside',
          'header'  => 'Header',
        ],
        'default_value' => 'section'
      ])
      ->addSelect('container_width', [
        'label' => 'Container Width',
        'choices' => [
          'default' => 'Default',
          'narrow' => 'Narrow',
          'wide' => 'Wide',
          'full' => 'Full',
        ],
        'default_value' => 'default',
      ])
      ->addSelect('padding_top', [
        'label' => 'Top Padding',
        'choices' => [
          'none' => 'None',
          'sm' => 'Small',
          'md' => 'Medium',
          'lg' => 'Large',
          'xl' => 'XL',
        ],
        'default_value' => 'lg',
      ])
      ->addSelect('padding_bottom', [
        'label' => 'Bottom Padding',
        'choices' => [
          'none' => 'None',
          'sm' => 'Small',
          'md' => 'Medium',
          'lg' => 'Large',
          'xl' => 'XL',
        ],
        'default_value' => 'lg',
      ])
      ->addSelect('background_color', [
        'label' => 'Background Color',
        'choices' => [
          'none' => 'None',
          'light' => 'Light',
          'dark' => 'Dark',
          'accent' => 'Accent',
        ],
        'default_value' => 'none',
      ])
      ->addTrueFalse('overflow_hidden', [
        'label' => 'Hide Overflow',
        'ui' => 1,
      ])
    ->endGroup();

    return $fields;
  }
}