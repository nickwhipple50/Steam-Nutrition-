<?php

namespace MMM\FieldGroups\FlexibleContent;

use MMM\FieldGroups\Partials\{MotionPartial, SectionSettingsPartial};
use StoutLogic\AcfBuilder\{FieldNameCollisionException, FieldsBuilder};

abstract class BaseLayout {
  protected FieldsBuilder $fields;

  /**
   * @return FieldsBuilder
   * @throws FieldNameCollisionException
   */
  public function build(): FieldsBuilder
  {
    $this->fields = new FieldsBuilder( $this->getName() );

    // Layout-specific fields
    $this->addFields();

    // Global section primitives
    $this->fields->addTab( 'Section Settings' )
      ->addFields( SectionSettingsPartial::get() );

    $this->fields->addTab( 'Motion' )
      ->addFields( MotionPartial::get() );

    return $this->fields;
  }

  abstract public function getName(): string;

  /**
   * @return void
   * @throws FieldNameCollisionException
   */
  abstract protected function addFields(): void;

  public function getView(): string
  {
    return 'views/partials/sections/' . $this->getName() . '.twig';
  }

  public function getConfig(): array
  {
    return [
      'name' => $this->getName(),
      'label' => $this->getLabel(),
      'display' => $this->getDisplay(),
      'min' => $this->getMin(),
      'max' => $this->getMax(),
    ];
  }

  abstract protected function getLabel(): string;

  protected function getDisplay(): string
  {
    return 'block';
  }

  protected function getMin(): string
  {
    return '';
  }

  protected function getMax(): string
  {
    return '';
  }
}