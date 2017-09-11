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
            foreach ($this as $key => $value) {
                yield $key => $callback($value, $key);
            }
        });
    }

    /**
     * Transform each value in the collection.
     *
     * @param  string  $class
     * @return static
     */
    public function mapInto($class): self
    {
        return $this->map(function ($value, $key) use ($class) {
            return new $class($value, $key);
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
            foreach ($this as $key => $value) {
                yield $callback($value, $key) => $value;
            }
        });
    }

    /**
     * Transform each key in the collection.
     *
     * @return static
     */
    public function keyByValue(): self
    {
        return $this->keyBy(function ($value) {
            return $value;
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
            foreach ($this as $items) {
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
            foreach ($this as $key => $value) {
                if ($callback($value, $key)) {
                    yield $key => $value;
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
    public function reject(callable $callback): self
    {
        return $this->filter(function ($value, $key) use ($callback) {
            return ! $callback($value, $key);
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

            foreach ($this as $key => $value) {
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
     * @param  iterable... $collections
     * @return static
     */
    public function zip(...$collections): self
    {
        $collections = static::splat($this, ...$collections);

        return new static(function () use ($collections) {
            $iterators = $collections->map->getIterator()->eager();

            // Yield the values from each collection and move to the next item
            while ($iterators->contains->valid()) {
                yield $iterators->map->current();

                $iterators->each->next();
            }
        });
    }

    /**
     * Return the result of passing the entire collection to a callback.
     *
     * @param  callable  $callback
     * @return mixed
     */
    public function pipe(callable $callback)
    {
        return $callback($this);
    }

    /**
     * Return the result of passing the entire collection through a series of callbacks.
     *
     * @param  callable[]  $callbacks
     * @return mixed
     */
    public function pipeThrough(/* iterable */ $callbacks)
    {
        return (new static($callbacks))->reduce(function ($collection, $callback) {
            return $collection->pipe($callback);
        }, $this);
    }
}
