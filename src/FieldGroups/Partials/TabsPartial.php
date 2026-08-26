<?php

namespace MMM\FieldGroups\Partials;

use StoutLogic\AcfBuilder\FieldsBuilder;

class TabsPartial extends BasePartial
{
  public static function get(): FieldsBuilder
  {
    $fields = new FieldsBuilder( 'tabs' );

    $fields
      ->addRepeater( 'tab_items', [
        'label'        => __( 'Tab Items', 'mcguinnessmedia' ),
        'button_label' => __( 'Add Tab', 'mcguinnessmedia' ),
        'min'          => 1,
        'layout'       => 'block',
      ] )
      ->addText( 'heading', [
        'label'    => __( 'Tab Label', 'mcguinnessmedia' ),
        'required' => true,
      ] )
      ->addWysiwyg( 'content', [
        'label'    => __( 'Panel Content', 'mcguinnessmedia' ),
        'required' => true,
        'tabs'     => 'visual',
        'toolbar'  => 'basic',
        'delay'    => true,
      ] )
      ->endRepeater();

    return $fields;
  }
}