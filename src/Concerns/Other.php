<?php

namespace TheCrypticAce\Lazy\Concerns;

trait Other
{
    /**
     * Get a zero-indexed series of keys of the collection items.
     *
     * @return static
     */
    public function keys(): self
    {
        return new static(function () {
            foreach ($this as $key => $_) {
                yield $key;
            }
        });
    }

    /**
     * Get a zero-indexed series of values of the collection items.
     *
     * @return static
     */
    public function values(): self
    {
        return new static(function () {
            foreach ($this as $value) {
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
        foreach ($this as $key => $item) {
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
     * @param  int  $count
     * @return static
     */
    public function chunk(int $count): self
    {
        assert($count > 0, "You cannot chunk items into groups of size zero");

        return new static(function () use ($count) {
            $i = 0;

            $batch = [];

            foreach ($this as $value) {
                $i += 1;

                $batch[] = $value;

                if ($i === $count) {
                    yield new static($batch);

                    $i = 0;
                    $batch = [];
                }
            }

            if (! empty($batch)) {
                yield new static($batch);
            }
        });
    }

    /**
     * Return a new collection with the series
     * of items prepended to the current one.
     *
     * @param  iterable  $items
     * @return static
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
     * of items appended to the current one.
     *
     * @param  iterable  $items
     * @return static
     */
    public function append($items): self
    {
        return new static(function () use ($items) {
            yield from $this;
            yield from $items;
        });
    }

    /**
     * Return result of callback when the given condition
     * is true. Otherwise: return this collection.
     *
     * @param  bool|Closure  $condition
     * @param  callable  $callback
     * @return mixed
     */
    public function when($condition, callable $callback)
    {
        if ($value = value($condition)) {
            return $callback($this, $value);
        }

        return $this;
    }

    /**
     * Run a callback when processing each item in a collection.
     *
     * @param  callable  $callback
     * @return mixed
     */
    public function during(callable $callback)
    {
        return $this->map(function ($value, $key) use ($callback) {
            $callback($value, $key);

            return $value;
        });
    }

    /**
     * Pass this collection to the given callback to allow for pipeline side effects.
     *
     * @param  callable  $callback
     * @return mixed
     */
    public function tap(callable $callback)
    {
        $callback($this);

        return $this;
    }

    /**
     * Unique items in a given collection based on a given callback.
     *
     * @param  callable  $callback
     * @return mixed
     */
    public function unique(callable $callback = null)
    {
        $callback = $callback ?? function ($value) {
            if (is_object($value)) {
                return spl_object_hash($value);
            }

            return $value;
        };

        return new static(function () use ($callback) {
            $processed = [];

            foreach ($this as $key => $item) {
                $id = $callback($item, $key);

                if (isset($processed[$id])) {
                    continue;
                }

                yield $key => $processed[$id] = $item;
            }
        });
    }
}
