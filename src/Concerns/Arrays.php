<?php

namespace TheCrypticAce\Lazy\Concerns;

use Illuminate\Contracts\Support\Jsonable;
use Illuminate\Contracts\Support\Arrayable;

trait Arrays
{
    /**
     * Convert the collection and all entries (deeply) inside it to an array when possible.
     *
     * @return array
     */
    public function toArray()
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
    public function all()
    {
        return iterator_to_array($this->items, true);
    }

    /**
     * Return a collection backed by an array. Good for reiteration.
     *
     * @return array
     */
    public function eager()
    {
        return new static($this->all());
    }

    /**
     * Convert to an Illuminate Collection.
     *
     * @return array
     */
    public function collect()
    {
        return collect($this->all());
    }
}
