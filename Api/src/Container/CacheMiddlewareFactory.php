<?php
/**
 * Created by khaled.
 */
namespace CanExpressive\Api\Container;
use Doctrine\Common\Cache\Cache;
use Interop\Container\ContainerInterface;
class CacheMiddlewareFactory
{
    public function __invoke(ContainerInterface $container)
    {
        $cache = $container->get(Cache::class);
        return new CacheMiddleware($cache);
    }
}