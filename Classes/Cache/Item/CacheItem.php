<?php


namespace TheWorldsCMS\Journey\Cache\Item;


use Psr\Cache\CacheItemInterface;

/**
 * Class CacheItem
 * @package TheWorldsCMS\Journey\Cache\Item
 */
class CacheItem implements CacheItemInterface {

    /**
     * @var string
     */
    protected $cacheKey;

    /**
     * @var mixed
     */
    protected $cacheValue;

    /**
     * @return string
     */
    public function getKey() {
        return $this->cacheKey;
    }

    /**
     * @return mixed
     */
    public function get() {
        return $this->cacheValue;
    }

    /**
     * @return bool
     */
    public function isHit() {

    }

    /**
     * @param mixed $value
     * @return CacheItem
     */
    public function set($value) {

    }

    /**
     * @param \DateTimeInterface|null $expiration
     * @return CacheItem|void
     */
    public function expiresAt($expiration) {
        // TODO: Implement expiresAt() method.
    }

    /**
     * @param \DateInterval|int|null $time
     * @return CacheItem|void
     */
    public function expiresAfter($time) {
        // TODO: Implement expiresAfter() method.
    }
}