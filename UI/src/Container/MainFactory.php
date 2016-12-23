<?php

namespace CanExpressive\UI\Container;

use CanExpressive\UI\Main;
use Interop\Container\ContainerInterface;

class MainFactory
{

  public function __invoke(ContainerInterface $container)
  {
    $config = $container->get('config');
    $cacheEnabled = (isset($config['view']['cache']))? (bool)$config['view']['cache'] : false;
    $layout = (isset($config['view']['layout']) && is_string($config['view']['layout']))
        ? $config['view']['layout'] : 'UI/templates/layout/layout.phtml';

    return new Main($layout,$cacheEnabled);
  }
}
