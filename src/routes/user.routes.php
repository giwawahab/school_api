<?php
namespace PH7\ApiPortal;

use Exception;
use PH7\ApiPortal\Validation\Exception\InvalidValidationException;
use PH7\JustHttp\StatusCode;
use PH7\PhpHttpResponseHeader\Http;

require_once dirname(__DIR__) . '/endpoints/User.php';

enum UserAction: string{

  case CREATE = "create";
  case RETRIEVE = "retrieve";
  case RETRIEVE_ALL = "retrieveAll";
  case UPDATE = "update";
  case REMOVE = "remove";

  public function getResponse() : string 
  {
    $postBody = file_get_contents('php://input');
    $postBody = json_decode($postBody);
    
    // null coallescing operator
    $userId = $_GET['user_id'] ?? null;

    // TODO: Remove the hard-coded values from user
    $user = new User("Giwa Wahab", "giwa123@gmail.com", "09162233055");

    try{
    
    $response =  match ($this){

      self::CREATE => $user->create($postBody),
      
      self::RETRIEVE => $user->retrieve($userId),

      self::RETRIEVE_ALL => $user->retrieveAll(),
    
      self::UPDATE => $user->update($postBody),
    
      self::REMOVE => $user->remove($userId),
    };

  } catch (InvalidValidationException | Exception $e){
  
    // send 400 http status code
    Http::setHeadersByCode(StatusCode::BAD_REQUEST);
    $response = [
      'errors'=> [
          'message'=> $e->getMessage(), 
          'code'=> $e->getCode(), 
      ]
    ];
  }

    return json_encode($response);
  }
  
}


$action = $_GET['action'] ?? null;

// PHP 8.0 match - http://stitcher.io/blog/php-8-match-or-switch
$userAction =  match($action){
   'create' => UserAction::CREATE, // send 201
   'retrieve' => UserAction::RETRIEVE, // send 200
   'update' => UserAction::UPDATE,
   'remove' => UserAction::REMOVE, //send 204
   default => UserAction::RETRIEVE_ALL, // send 200
};


// response, as describe in https://jsonapi.org/format/#profile-rules
echo $userAction->getResponse();

