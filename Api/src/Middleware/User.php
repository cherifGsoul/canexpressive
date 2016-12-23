<?php

namespace CanExpressive\Api\Middleware;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Zend\Diactoros\Response\JsonResponse;

/**
 *
 */
class User
{
  public function __invoke(Request $request, Response $response,callable $next = null)
  {
  }

  public function get(Request $request, Response $response,callable $next = null)
  {

  }

  public function post(Request $request, Response $response,callable $next = null)
  {

  }

  public function put(Request $request, Response $response,callable $next = null)
  {

  }

  public function delete(Request $request, Response $response,callable $next = null)
  {

  }


}
