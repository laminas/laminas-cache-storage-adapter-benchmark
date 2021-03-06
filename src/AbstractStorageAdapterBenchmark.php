<?php

declare(strict_types=1);

namespace Laminas\Cache\Storage\Adapter\Benchmark;

use Laminas\Cache\Storage\StorageInterface;

use function array_keys;

/**
 * @BeforeMethods({"setUp"})
 * @AfterMethods({"tearDown"})
 */
abstract class AbstractStorageAdapterBenchmark
{
    /** @var StorageInterface */
    protected $storage;

    /**
     * Key-Value-Pairs of existing items
     *
     * @var array<string,int>
     */
    protected $warmItems = [];

    /**
     * Key-Value-Pairs of missing items
     *
     * @var array<string,int>
     */
    protected $coldItems = [];

    public function __construct(StorageInterface $storage)
    {
        $this->storage = $storage;

        // generate warm items
        for ($i = 0; $i < 10; $i++) {
            $this->warmItems['warm' . $i] = $i;
        }

        // generate cold items
        for ($i = 0; $i < 10; $i++) {
            $this->coldItems['cold' . $i] = $i;
        }
    }

    public function setUp(): void
    {
        $this->storage->setItems($this->warmItems);
    }

    public function tearDown(): void
    {
        $this->storage->removeItems(array_keys($this->coldItems));
    }

    /**
     * Has missing items with single operations
     */
    public function benchHasMissingItemsSingle(): void
    {
        foreach ($this->coldItems as $k => $_) {
            $this->storage->hasItem($k);
        }
    }

    /**
     * Has missing items at once
     */
    public function benchHasMissingItemsBulk(): void
    {
        $this->storage->hasItems(array_keys($this->coldItems));
    }

    /**
     * Has existing items with single operations
     */
    public function benchHasExistingItemsSingle(): void
    {
        foreach ($this->warmItems as $k => $_) {
            $this->storage->hasItem($k);
        }
    }

    /**
     * Has existing items at once
     */
    public function benchHasExistingItemsBulk(): void
    {
        $this->storage->hasItems(array_keys($this->warmItems));
    }

    /**
     * Set existing items with single operations
     */
    public function benchSetExistingItemsSingle(): void
    {
        foreach ($this->warmItems as $k => $v) {
            $this->storage->setItem($k, $v);
        }
    }

    /**
     * Set existingn items at once
     */
    public function benchSetExistingItemsBulk(): void
    {
        $this->storage->setItems($this->warmItems);
    }

    /**
     * Set missing items with single operations
     */
    public function benchSetMissingItemsSingle(): void
    {
        foreach ($this->coldItems as $k => $v) {
            $this->storage->setItem($k, $k . $v);
        }
    }

    /**
     * Set missing items at once
     */
    public function benchSetMissingItemsBulk(): void
    {
        $this->storage->setItems($this->coldItems);
    }

    /**
     * Add items with single operations
     */
    public function benchAddItemsSingle(): void
    {
        foreach ($this->coldItems as $k => $v) {
            $this->storage->addItem($k, $k . $v);
        }
    }

    /**
     * Add items at once
     */
    public function benchAddItemsBulk(): void
    {
        $this->storage->addItems($this->coldItems);
    }

    /**
     * Replace items with single operations
     */
    public function benchReplaceItemsSingle(): void
    {
        foreach ($this->warmItems as $k => $v) {
            $this->storage->replaceItem($k, $k . $v);
        }
    }

    /**
     * Replace items at once
     */
    public function benchReplaceItemsBulk(): void
    {
        $this->storage->replaceItems($this->coldItems);
    }

    /**
     * Get, check and set items with single operations
     */
    public function benchGetCheckAndSetItemsSingle(): void
    {
        foreach ($this->warmItems as $k => $v) {
            $this->storage->getItem($k, $success, $token);
            $this->storage->checkAndSetItem($token, $k, $k . $v);
        }
    }

    /**
     * Touch missing items with single operations
     */
    public function benchTouchMissingItemsSingle(): void
    {
        foreach ($this->coldItems as $k => $_) {
            $this->storage->touchItem($k);
        }
    }

    /**
     * Touch missing items at once
     */
    public function benchTouchMissingItemsBulk(): void
    {
        $this->storage->touchItems(array_keys($this->coldItems));
    }

    /**
     * Touch existing items with single operations
     */
    public function benchTouchExistingItemsSingle(): void
    {
        foreach ($this->warmItems as $k => $_) {
            $this->storage->touchItem($k);
        }
    }

    /**
     * Touch existing items at once
     */
    public function benchTouchExistingItemsBulk(): void
    {
        $this->storage->touchItems(array_keys($this->warmItems));
    }

    /**
     * Get missing items with single operations
     */
    public function benchGetMissingItemsSingle(): void
    {
        foreach ($this->coldItems as $k => $_) {
            $this->storage->getItem($k);
        }
    }

    /**
     * Get missing items at once
     */
    public function benchGetMissingItemsBulk(): void
    {
        $this->storage->getItems(array_keys($this->coldItems));
    }

    /**
     * Get existing items with single operations
     */
    public function benchGetExistingItemsSingle(): void
    {
        foreach ($this->warmItems as $k => $_) {
            $this->storage->getItem($k);
        }
    }

    /**
     * Get existing items at once
     */
    public function benchGetExistingItemsBulk(): void
    {
        $this->storage->getItems(array_keys($this->warmItems));
    }

    /**
     * Remove missing items with single operations
     */
    public function benchRemoveMissingItemsSingle(): void
    {
        foreach ($this->coldItems as $k => $_) {
            $this->storage->removeItem($k);
        }
    }

    /**
     * Remove missing items at once
     */
    public function benchRemoveMissingItemsBulk(): void
    {
        $this->storage->removeItems(array_keys($this->coldItems));
    }

    /**
     * Remove exisint items with single operations
     */
    public function benchRemoveExistingItemsSingle(): void
    {
        foreach ($this->warmItems as $k => $_) {
            $this->storage->removeItem($k);
        }
    }

    /**
     * Remove existing items at once
     */
    public function benchRemoveExistingItemsBulk(): void
    {
        $this->storage->removeItems(array_keys($this->warmItems));
    }

    /**
     * Increment missing items with single operations
     */
    public function benchIncrementMissingItemsSingle(): void
    {
        foreach ($this->coldItems as $k => $v) {
            $this->storage->incrementItem($k, $v);
        }
    }

    /**
     * Increment missing items at once
     */
    public function benchIncrementMissingItemsBulk(): void
    {
        $this->storage->incrementItems($this->coldItems);
    }

    /**
     * Increment exisint items with single operations
     */
    public function benchIncrementExistingItemsSingle(): void
    {
        foreach ($this->warmItems as $k => $v) {
            $this->storage->incrementItem($k, $v);
        }
    }

    /**
     * Increment existing items at once
     */
    public function benchIncrementExistingItemsBulk(): void
    {
        $this->storage->incrementItems($this->warmItems);
    }

    /**
     * Decrement missing items with single operations
     */
    public function benchDecrementMissingItemsSingle(): void
    {
        foreach ($this->coldItems as $k => $v) {
            $this->storage->decrementItem($k, $v);
        }
    }

    /**
     * Decrement missing items at once
     */
    public function benchDecrementMissingItemsBulk(): void
    {
        $this->storage->decrementItems($this->coldItems);
    }

    /**
     * Decrement exisint items with single operations
     */
    public function benchDecrementExistingItemsSingle(): void
    {
        foreach ($this->warmItems as $k => $v) {
            $this->storage->decrementItem($k, $v);
        }
    }

    /**
     * Decrement existing items at once
     */
    public function benchDecrementExistingItemsBulk(): void
    {
        $this->storage->decrementItems($this->warmItems);
    }
}
