<?php

$resource = $_GET["resource"] ?? null;

switch($resource){

  case 'user':
    return require_once "user.routes.php";
    break;

  default:
    // 404
}