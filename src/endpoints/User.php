<?php

namespace PH7\ApiPortal;
use Respect\Validation\Validator as v;

use PH7\ApiPortal\Validation\Exception\InvalidValidationException;
use PH7\ApiPortal\Validation\UserValidation;

class User{

  public readonly ?string $userId;

  public function __construct(public readonly string $name, 
                              public readonly string $email, 
                              public readonly string $phone,
                              ){}

  public function create(mixed $data): object{

    // storing min/max length for first/last names
    $minimumLength = 2;
    $maximumLength = 60;

    // validate data
    $userValidation = new UserValidation($data);
    if($userValidation->isCreationSchemaValid()){
      return $data;  // return statement exits the function and it does not go beyond this scope
    }

    throw new InvalidValidationException("Invalid user payload, Please Check Your Inputs 💥");

  }

  public function retrieveAll(): array{
    return [];
  }

  // could be UUID/GUID too. So, read to change user ID to string. we may not use increment IDs here
  public function retrieve(string $userId): self{

    if(v::uuid()->validate($userId)){
      $this->userId = $userId;
      return $this;
    }
      
    throw new InvalidValidationException("Invalid user UUID supplied");
    

  }

  public function update(mixed $postBody): object{

    // validate data
    $userValidation = new UserValidation($postBody);
    if($userValidation->isUpdateSchemaValid()){
      return $postBody;  // return statement exit the function and it does not go beyond this scope
    }
    throw new InvalidValidationException("Invalid user payload, Please Check Your Inputs 💥");
  }

  public function remove(string $userId): bool{

    // TODO: Lookup the DB user row with this userId

    if(v::uuid()->validate($userId)){
        $this->userId = $userId;
      }else{
        throw new InvalidValidationException("Invalid user UUID supplied");
      }

      return true; // default value;
    }

  
}