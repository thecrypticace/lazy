<?php

namespace TheCrypticAce\Lazy\Concerns;

trait Other
{
    /**
     * Get a zero-index series of keys of the collection items.
     *
     * @return static
     */
    public function keys()
    {
        return new static(function () {
            foreach ($this->items as $key => $_) {
                yield $key;
            }
        });
    }

    /**
     * Get a zero-index series of values of the collection items.
     *
     * @return static
     */
    public function values()
    {
        return new static(function () {
            foreach ($this->items as $value) {
                yield $value;
            }
        });
    }

    /**
     * Execute a callback for each item.
     *
     * @param  callable  $callback
     * @return $this
     */
    public function each(callable $callback)
    {
        foreach ($this->items as $key => $item) {
            if ($callback($item, $key) === false) {
                break;
            }
        }

        return $this;
    }
}
