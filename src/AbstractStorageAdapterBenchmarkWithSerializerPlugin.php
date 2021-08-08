<?php

declare(strict_types=1);

namespace Laminas\Cache\Storage\Adapter\Benchmark;

use Laminas\Cache\Storage\Plugin\Serializer;
use Laminas\Cache\Storage\PluginAwareInterface;
use Laminas\Cache\Storage\StorageInterface;

abstract class AbstractStorageAdapterBenchmarkWithSerializerPlugin extends AbstractStorageAdapterBenchmark
{
    /**
     * @param PluginAwareInterface&StorageInterface $storage
     */
    public function __construct(PluginAwareInterface $storage)
    {
        $storage->addPlugin(new Serializer());
        parent::__construct($storage);
    }
}
