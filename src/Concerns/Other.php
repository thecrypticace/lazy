<?php

namespace TheCrypticAce\Lazy\Concerns;

trait Other
{
    /**
     * Get a zero-index series of keys of the collection items.
     *
     * @return static
     */
    public function keys(): self
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
    public function values(): self
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
    public function each(callable $callback): self
    {
        foreach ($this->items as $key => $item) {
            if ($callback($item, $key) === false) {
                break;
            }
        }

        return $this;
    }

    /**
     * Chunk items into groups of a given size.
     *
     * The last chunk will contain fewer than `count`
     * items when the collection is not large enough
     *
     * @param  callable  $callback
     * @return $this
     */
    public function chunk(int $count): self
    {
        assert($count > 0, "You cannot chunk items into groups of size zero");

        return new static(function () use ($count) {
            $i = 0;

            $batch = [];

            foreach ($this->items as $value) {
                $i += 1;

                $batch[] = $value;

                if ($i === $count) {
                    yield new static($batch);

                    $i = 0;
                    $batch = [];
                }
            }

            if ($batch) {
                yield new static($batch);
            }
        });
    }

    /**
    * Return a new collection with the series
    * of items prepended to the current one
     *
     * @param  callable  $callback
     * @return $this
     */
    public function prepend($items): self
    {
        return new static(function () use ($items) {
            yield from $items;
            yield from $this;
        });
    }

    /**
     * Return a new collection with the series
     * of items appended to the current one
     *
     * @param  callable  $callback
     * @return $this
     */
    public function append($items): self
    {
        return new static(function () use ($items) {
            yield from $this;
            yield from $items;
        });
    }
}
