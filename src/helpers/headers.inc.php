<?php
namespace PH7\ApiPortal;

use PH7\PhpHttpResponseHeader\Http;

(new AllowCors)->init();

Http::setContentType("application/json");