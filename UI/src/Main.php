<?php

namespace CanExpressive\UI;

use Psr\Http\Message\RequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;


class Main
{
  private $cacheEnabled;
  private $layout;
  private $layoutCacheFile = 'data/cache/layout.phtml';

  public function __construct($layout,$cacheEnabled)
  {
      $this->cacheEnabled = $cacheEnabled;
      $this->layout = $layout;
  }

  public function __invoke(Request $request, Response $response,callable $next)
  {
    $layout = $this->renderLayout();
    $response->getBody()->write($layout);
    return $response;
  }

  private function renderLayout()
  {
    if ($this->cacheEnabled && file_exists($this->layoutCacheFile)) {
        return file_get_contents($this->layoutCacheFile);
    }

    $layout = "";
    try {
        ob_start();
        $includeReturn = include $this->layout;
        $layout = ob_get_clean();
    } catch (\Exception $ex) {
        ob_end_clean();
        throw $ex;
    }
    if ($includeReturn === false && empty($layout)) {
        throw new \UnexpectedValueException(sprintf(
            'Unable to render layout "%s"; file include failed',
            $this->layout
        ));
    }

    if ($this->cacheEnabled) {
        file_put_contents($this->layoutCacheFile, $layout);
    }

    return $layout;
  }
}
