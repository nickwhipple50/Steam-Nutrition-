<?php

namespace MMM\FieldGroups\Partials;

use StoutLogic\AcfBuilder\FieldsBuilder;

class AccordionPartial extends BasePartial
{
  public static function get(): FieldsBuilder
  {
    $fields = new FieldsBuilder( 'accordion' );

    $fields
      ->addRepeater( 'accordion_items', [
        'label'        => __( 'Accordion Items', 'mcguinnessmedia' ),
        'button_label' => __( 'Add Item', 'mcguinnessmedia' ),
        'min'          => 1,
        'layout'       => 'block',
      ] )
      ->addText( 'heading', [
        'label'    => __( 'Heading', 'mcguinnessmedia' ),
        'required' => true,
      ] )
      ->addWysiwyg( 'content', [
        'label'    => __( 'Content', 'mcguinnessmedia' ),
        'required' => true,
        'tabs'     => 'visual',
        'toolbar'  => 'basic',
        'delay'    => true,
      ] )
      ->endRepeater();

    return $fields;
  }
}