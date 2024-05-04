<?php
namespace PH7\ApiPortal\Validation;
use Respect\Validation\Validator as v;

class UserValidation{

  private const MINIMUM_NAME_LENGTH = 2;
  private const MAXIMUM_NAME_LENGTH = 60;

  public function __construct(private mixed $data){}

  public function isCreationSchemaValid(): bool{

      // validation schema
      $schemaValidation = v::attribute('first', v::stringType()->length(self::MINIMUM_NAME_LENGTH, self::MAXIMUM_NAME_LENGTH))
          ->attribute('last', v::stringType()->length(self::MINIMUM_NAME_LENGTH, self::MAXIMUM_NAME_LENGTH))
          ->attribute('email', v::email(), mandatory: false) // named argument since php 8
          ->attribute('phone', v::phone(), mandatory: false);

      return $schemaValidation->validate($this->data);
  }

  public function isUpdateSchemaValid(): bool{

    // The same schema for both creation and update
    return $this->isCreationSchemaValid();
  }
}