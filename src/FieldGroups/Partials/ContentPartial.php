<?php

namespace MMM\FieldGroups\Partials;

use StoutLogic\AcfBuilder\FieldsBuilder;

class ContentPartial extends BasePartial {
  public static function get(): FieldsBuilder
  {
    $fields = new FieldsBuilder( 'section_content' );

    $fields
      ->addGroup( 'content' )
      ->addText( 'eyebrow', [
        'label' => 'Eyebrow',
        'instructions' => 'Short label above the heading'
      ] )
      ->addText( 'heading', [
        'required' => true
      ] )
      ->addTextarea( 'lead', [
        'label' => 'Lead Text',
        'instructions' => 'Optional introductory paragraph'
      ] )
      ->addWysiwyg( 'content', [
        'required' => false,
        'toolbar' => 'basic',
        'media_upload' => 0
      ] )
      ->addRepeater( 'buttons', [
        'layout' => 'row',
        'button_label' => 'Add Button'
      ] )
      ->addLink( 'button' )
      ->addSelect( 'style', [
        'label' => 'Button Style',
        'choices' => [
          'primary' => 'Primary',
          'secondary' => 'Secondary',
          'text' => 'Text Link'
        ],
        'default_value' => 'primary'
      ] )
      ->endRepeater()
      ->addSelect( 'max_width', [
        'label' => 'Content Width',
        'choices' => [
          'sm' => 'Small',
          'md' => 'Medium',
          'lg' => 'Large',
          'full' => 'Full Width'
        ],
        'default_value' => 'md'
      ] )
      ->endGroup();

    return $fields;
  }
}