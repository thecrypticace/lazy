<?php

namespace TheCrypticAce\Lazy\Concerns;

trait Other
{
    /**
     * Get the keys of the collection items.
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
     * Get the values of the collection items.
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
     * Execute a callback over each item.
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
