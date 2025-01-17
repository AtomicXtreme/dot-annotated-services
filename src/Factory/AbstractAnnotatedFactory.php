<?php

declare(strict_types=1);

namespace Dot\AnnotatedServices\Factory;

use Doctrine\Common\Annotations\AnnotationReader;
use Doctrine\Common\Annotations\PsrCachedReader;
use Doctrine\Common\Annotations\Reader;
use Psr\Cache\CacheItemPoolInterface;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\ContainerInterface;
use Psr\Container\NotFoundExceptionInterface;

abstract class AbstractAnnotatedFactory
{
    public const CACHE_SERVICE          = CacheItemPoolInterface::class;
    protected ?Reader $annotationReader = null;
    public function setAnnotationReader(Reader $annotationReader): void
    {
        $this->annotationReader = $annotationReader;
    }

    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    protected function createAnnotationReader(ContainerInterface $container): Reader
    {
        if ($this->annotationReader !== null) {
            return $this->annotationReader;
        }

        if (! $container->has(self::CACHE_SERVICE)) {
            return $this->annotationReader = new AnnotationReader();
        } else {
            /** @var CacheItemPoolInterface $cache */
            $cache = $container->get(self::CACHE_SERVICE);
            $debug = false;
            if ($container->has('config')) {
                $config = $container->get('config');
                if (isset($config['debug'])) {
                    $debug = (bool) $config['debug'];
                }
            }
            return $this->annotationReader = new PsrCachedReader(new AnnotationReader(), $cache, $debug);
        }
    }
}
