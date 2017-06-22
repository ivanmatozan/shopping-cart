<?php

namespace Cart\Support\Storage;

use Countable;
use Cart\Support\Storage\Contracts\StorageInterface;

class SessionStorage implements StorageInterface, Countable
{
    /**
     * Name of the current bucket
     *
     * @var string
     */
    protected $bucket;

    public function __construct(string $bucket = 'default')
    {
        // Set bucket to session if it isn't in
        if (!isset($_SESSION[$bucket])) {
            $_SESSION[$bucket] = [];
        }

        $this->bucket = $bucket;
    }

    /**
     * Set index/value pair to current bucket
     *
     * @param mixed $index
     * @param mixed $value
     */
    public function set($index, $value) {
        $_SESSION[$this->bucket][$index] = $value;
    }

    /**
     * Get value from current bucket at specified index
     *
     * @param mixed $index
     * @return mixed Value if index is set, null otherwise
     */
    public function get($index) {
        if (!$this->exists($index)) {
            return null;
        }

        return $_SESSION[$this->bucket][$index];
    }

    /**
     * Check if index is set in current bucket
     *
     * @param mixed $index
     * @return bool
     */
    public function exists($index): bool
    {
        return isset($_SESSION[$this->bucket][$index]);
    }

    /**
     * Get whole bucket
     *
     * @return array
     */
    public function all(): array
    {
        return $_SESSION[$this->bucket];
    }

    /**
     * Unset specified index from bucket
     *
     * @param mixed $index
     */
    public function remove($index)
    {
        if ($this->exists($index)) {
            unset($_SESSION[$this->bucket][$index]);
        }
    }

    /**
     * Unset whole bucket from session
     */
    public function clear()
    {
        unset($_SESSION[$this->bucket]);
    }

    /**
     * Count all items in bucket
     *
     * @return int
     */
    public function count()
    {
        return count($this->all());
    }
}