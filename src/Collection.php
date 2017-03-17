<?php

namespace TheCrypticAce\Lazy;

use Closure;
use Traversable;
use ArrayIterator;
use IteratorAggregate;
use Illuminate\Support\Traits\Macroable;
use Illuminate\Contracts\Support\Arrayable;

final class Collection implements IteratorAggregate, Arrayable
{
    use Macroable;
    use Concerns\Range;
    use Concerns\Tests;
    use Concerns\Other;
    use Concerns\Arrays;
    use Concerns\Proxies;
    use Concerns\Functional;
    use Concerns\Statistics;

    /**
     * The items contained in the collection.
     *
     * @var Traversable
     */
    protected $items;

    /**
     * Create a new collection.
     *
     * @param  mixed  $items
     * @return void
     */
    public function __construct($items = [])
    {
        if ($items instanceof Closure) {
            $items = $items();
        }

        $this->items = $this->getIterableItems($items);
    }

    /**
     * Get an iterator for the items.
     *
     * @return Traversable
     */
    public function getIterator(): Traversable
    {
        return $this->items;
    }

    /**
     * Results iterator of items from Collection.
     *
     * @param  mixed  $items
     * @return Traversable
     */
    private function getIterableItems($items): Traversable
    {
        if ($items instanceof self) {
            return $items->getIterator();
        }

        if ($items instanceof Traversable) {
            return $items;
        }

        return new ArrayIterator((array) $items);
    }

    /**
     * Results iterator of items from Collection.
     *
     * @param  mixed  $items
     * @return static
     */
    private static function splat(...$items): self
    {
        return (new static($items))->map(function ($item) {
            return new static($item);
        });
    }
}
