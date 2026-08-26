<?php

namespace MMM\FieldGroups\Partials;

use StoutLogic\AcfBuilder\FieldNameCollisionException;
use StoutLogic\AcfBuilder\FieldsBuilder;

abstract class BasePartial
{
  /**
   * @return FieldsBuilder
   * @throws FieldNameCollisionException
   */
  abstract public static function get(): FieldsBuilder;
}