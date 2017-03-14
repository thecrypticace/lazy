<?php

namespace TheCrypticAce\Lazy\Concerns;

trait Functional
{
    /**
     * Run a map over each of the items.
     *
     * @param  callable  $callback
     * @return static
     */
    public function map(callable $callback)
    {
        return new static(function () use ($callback) {
            foreach ($this->items as $key => $value) {
                yield $key => $callback($value, $key);
            }
        });
    }

    /**
     * Transform each key in the collection using $callback
     *
     * @param  callable  $callback
     * @return static
     */
    public function keyBy(callable $callback)
    {
        return new static(function () use ($callback) {
            foreach ($this->items as $key => $value) {
                yield $callback($value, $key) => $value;
            }
        });
    }

    /**
     * Map the items then flatten them
     *
     * @param  callable  $callback
     * @return static
     */
    public function flatMap(callable $callback)
    {
        return new static(function () use ($callback) {
            foreach ($this->items as $key => $value) {
                foreach ($callback($value, $key) as $subKey => $subValue) {
                    yield $subKey => $subValue;
                }
            }
        });
    }

    /**
     * Flatten two-dimensional entries into one-dimensional entries
     *
     * @param  callable  $callback
     * @return static
     */
    public function collapse()
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
     * Run a map over each of the items.
     *
     * @param  callable  $callback
     * @return static
     */
    public function filter(callable $callback)
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
     * @return mixed
     */
    public function accumulate(callable $callback, $initial = null)
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
        $accumulator = $initial;

        foreach ($this->accumulate($callback, $initial) as $value) {
            $accumulator = $value;
        }

        return $accumulator;
    }

    /**
     * Zip several collection's values together
     *
     * @param  callable  $callback
     * @param  mixed     $initial
     * @return mixed
     */
    public function zip(...$collections)
    {
        $collections = new static(array_merge([$this], array_map(function ($collection) {
            return new static($collection);
        }, $collections)));

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
