<?php

namespace MMM\FieldGroups\Partials;

use StoutLogic\AcfBuilder\FieldsBuilder;

class MotionPartial extends BasePartial
{
  public static function get(): FieldsBuilder
  {
    $fields = new FieldsBuilder('motion_settings');

    $fields->addGroup('motion')
      ->addTrueFalse('enable_animation', [
        'label' => 'Enable Animation',
        'ui' => 1
      ])

      ->addSelect('animation_type', [
        'choices' => [
          'fade'         => 'Fade',
          'slide-up'     => 'Slide Up',
          'slide-left'   => 'Slide Left',
          'slide-right'  => 'Slide Right',
          'scale'        => 'Scale',
          'stagger'      => 'Stagger Children'
        ],
        'default_value' => 'fade'
      ])->conditional('enable_animation', '==', 1)

      ->addNumber('delay', [
        'label' => 'Delay (ms)',
        'default_value' => 0
      ])->conditional('enable_animation', '==', 1)

      ->addNumber('duration', [
        'label' => 'Duration (ms)',
        'default_value' => 600
      ])->conditional('enable_animation', '==', 1)

      ->endGroup();

    return $fields;
  }
}