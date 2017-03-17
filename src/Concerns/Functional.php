<?php

namespace TheCrypticAce\Lazy\Concerns;

trait Functional
{
    /**
     * Transform each value in the collection.
     *
     * @param  callable  $callback
     * @return static
     */
    public function map(callable $callback): self
    {
        return new static(function () use ($callback) {
            foreach ($this->items as $key => $value) {
                yield $key => $callback($value, $key);
            }
        });
    }

    /**
     * Transform each key in the collection.
     *
     * @param  callable  $callback
     * @return static
     */
    public function keyBy(callable $callback): self
    {
        return new static(function () use ($callback) {
            foreach ($this->items as $key => $value) {
                yield $callback($value, $key) => $value;
            }
        });
    }

    /**
     * Returned a transformed, flattened series of collection entries.
     *
     * @param  callable  $callback
     * @return static
     */
    public function flatMap(callable $callback): self
    {
        return $this->map($callback)->collapse();
    }

    /**
     * Flatten two-dimensional entries into one-dimensional series of entries.
     *
     * @return static
     */
    public function collapse(): self
    {
        return new static(function () {
            foreach ($this->items as $items) {
                foreach ($items as $subKey => $subValue) {
                    yield $subKey => $subValue;
                }
            }
        });
    }

    /**
     * Keep or remove entries from the collection.
     *
     * @param  callable  $callback
     * @return static
     */
    public function filter(callable $callback): self
    {
        return new static(function () use ($callback) {
            foreach ($this->items as $key => $value) {
                if ($callback($value, $key)) {
                    yield $key => $value;
                }
            }
        });
    }

    /**
     * Gather all intermediate iterations when reducing the collection to a single value.
     *
     * @param  callable  $callback
     * @param  mixed     $initial
     * @return static
     */
    public function accumulate(callable $callback, $initial = null): self
    {
        return new static(function () use ($callback, $initial) {
            $accumulator = $initial;

            foreach ($this->items as $key => $value) {
                $accumulator = $callback($accumulator, $value, $key);

                yield $key => $accumulator;
            }
        });
    }

    /**
     * Reduce the collection to a single value.
     *
     * @param  callable  $callback
     * @param  mixed     $initial
     * @return mixed
     */
    public function reduce(callable $callback, $initial = null)
    {
        $accumulator = $this->accumulate($callback, $initial)->last();

        return $accumulator ?? $initial;
    }

    /**
     * Combine several collection's values together into pairs, triplets, etc….
     *
     * @param  callable  $callback
     * @param  mixed     $initial
     * @return static
     */
    public function zip(...$collections): self
    {
        $collections = $this->collectMany(array_merge([$this], $collections));

        return new static(function () use ($collections) {
            $iterators = $collections->map->getIterator()->eager();

            // Yield the values from each collection and move to the next item
            while ($iterators->contains->valid()) {
                yield $iterators->map->current();

                $iterators->each->next();
            }
        });
    }
}
