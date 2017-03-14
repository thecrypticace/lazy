<?php

namespace TheCrypticAce\Lazy\Concerns;

use Illuminate\Contracts\Support\Jsonable;
use Illuminate\Contracts\Support\Arrayable;

trait Arrays
{
    public function toArray()
    {
        $items = $this->map(function ($value) {
            return $value instanceof Arrayable ? $value->toArray() : $value;
        });

        return $items->all();
    }

    public function all()
    {
        return iterator_to_array($this->items, true);
    }

    public function eager()
    {
        return new static($this->all());
    }

    public function collect()
    {
        return collect($this->all());
    }
}
