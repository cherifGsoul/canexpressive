<?php
/**
 * Created by khaled.
 */

namespace CanExpressive\Api\Middleware;


use Doctrine\Common\Cache\Cache;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;

class CacheMiddleware
{

    protected $cache;

    public function __construct(Cache $cache)
    {
        $this->cache = $cache;
    }

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, callable $next = null)
    {
        $cachedResponse = $this->getCachedResponse($request, $response);
        if (null != $cachedResponse) {
            return $cachedResponse;
        }
        $response = $next($request, $response);
        $this->CacheResponse($request, $response);
        return $response;
    }

    /**
     * retrieve cached response
     *
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     * @return null|\Psr\Http\Message\MessageInterface|ResponseInterface
     */
    private function getCachedResponse(ServerRequestInterface $request, ResponseInterface $response)
    {
        if ('GET' != $request->getMethod())
            return null;

        $key = $this->getCacheKey($request);
        $item = $this->cache->fetch($key);
        if (false == $item)
            return null;

        $response->getBody()->write($item['body']);
        foreach ($item['headers'] as $name => $value) {
            $response = $response->withHeader($name, $value);
        }
        return $response;
    }

    /**
     * generate a cache key
     *
     * @param $request
     * @return string
     */
    private function getCacheKey($request)
    {
        return 'http-cache:' . $request->getUri()->getPath();
    }

    /**
     * cache response
     *
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     */
    private function cacheResponse(ServerRequestInterface $request, ResponseInterface $response)
    {
        if ('GET' != $request->getMethod() || !$response->hasHeader('Cache-Control'))
            return;
        $cacheKey =$this->getCacheKey($request);
        $this->cache->save(
            $cacheKey,[
                'headers' => $response->getHeaders(),
                'body' => (string)$response->getBody()
            ]);
        return;
    }
}
