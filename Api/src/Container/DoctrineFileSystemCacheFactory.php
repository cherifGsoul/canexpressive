<?php
/**
 * Created by khaled.
 */
namespace CanExpressive\Api\Container;
use Doctrine\Common\Cache\FilesystemCache;
use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Exception\ServiceNotCreatedException;
class DoctrineFilesystemCacheFactory
{
    public function __invoke(ContainerInterface $container)
    {
        $config = $container->has('config') ? $container->get('config') : [];
        if (!isset($config['view']['layout'])) {        	
            throw new ServiceNotCreatedException('cache_path must be set in application configuration');
        }
        return new FilesystemCache($config['view']['layout']);
    }
}