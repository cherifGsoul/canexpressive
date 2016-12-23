<?php

namespace CanExpressive\Api\Http\Action;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Zend\Diactoros\Response\JsonResponse;
use Psr7Middlewares\Middleware\AuraSession;

/**
 *
 */
class GetStatus
{
  public function __invoke(Request $request, Response $response)
  {
    return new JsonResponse(['message'=>'It works']);
  }
}
