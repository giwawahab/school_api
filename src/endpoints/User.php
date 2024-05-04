<?php

namespace PH7\ApiPortal;

use PH7\ApiPortal\Exception\InvalidValidationException;
use Respect\Validation\Validator as v;

class User{

  public readonly int $userId;

  public function __construct(public readonly string $name, 
                              public readonly string $email, 
                              public readonly string $phone)
  {
    
  }

  public function create(mixed $data): object{

    // storing min/max length for first/last names
    $minimumLength = 2;
    $maximumLength = 60;

    // validation schema
    $schemaValidation = v::attribute('first', v::stringType()->length($minimumLength, $maximumLength))
        ->attribute('last', v::stringType()->length($minimumLength, $maximumLength))
        ->attribute('email', v::email(), mandatory: false) // named argument since php 8
        ->attribute('phone', v::phone(), mandatory: false);

    if($schemaValidation->validate($data)){
      return $data;  // return statement exits the function and it does not go beyond this scope
    }

    throw new InvalidValidationException("Invalid Data, Please Check Your Inputs 💥");

  }

  public function retrieveAll(): array{
    return [];
  }

  // could be UUID/GUID too. So, read to change user ID to string. we may not use increment IDs here
  public function retrieve(string $userId): self{
    $this->userId = $userId;
    return $this;
  }

  public function update(mixed $postBody): self{

    // TODO Update `$postBody` to the DAL later on (for updating the database)
    return $this;
  }

  public function remove(string $userId): bool{

    // TODO: Lookup the DB user row with this userId

    return true; // default value
  }

  
}