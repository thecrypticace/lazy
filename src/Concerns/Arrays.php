<?php

namespace TheCrypticAce\Lazy\Concerns;

use Illuminate\Contracts\Support\Arrayable;

trait Arrays
{
    /**
     * Convert the collection and all entries (deeply) inside it to an array when possible.
     *
     * @return array
     */
    public function toArray(): array
    {
        $items = $this->map(function ($value) {
            return $value instanceof Arrayable ? $value->toArray() : $value;
        });

        return $items->all();
    }

    /**
     * Convert the collection to an array.
     *
     * @return array
     */
    public function all(): array
    {
        return iterator_to_array($this, true);
    }

    /**
     * Return a collection backed by an array. Good for reiteration.
     *
     * @return static
     */
    public function eager(): self
    {
        return new static($this->all());
    }
}
