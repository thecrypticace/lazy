<?php

namespace TheCrypticAce\Lazy\Concerns;

trait Tests
{
    /**
     * Get the first item from the collection or first item passing the given test.
     *
     * @param  callable|null  $callback
     * @param  mixed  $default
     * @return mixed
     */
    public function first(callable $callback = null, $default = null)
    {
        $callback = $callback ?? function () {
            return true;
        };

        foreach ($this->items as $key => $value) {
            if ($callback($value, $key)) {
                return $value;
            }
        }

        return value($default);
    }

    /**
     * Get the last item from the collection or last item passing the given test.
     *
     * @param  callable|null  $callback
     * @param  mixed  $default
     * @return mixed
     */
    public function last(callable $callback = null, $default = null)
    {
        $foundValue = null;

        foreach ($this->items as $key => $value) {
            if ($callback && $callback($value, $key)) {
                $foundValue = $value;
            } elseif (! $callback) {
                $foundValue = $value;
            }
        }

        return $foundValue ?? value($default);
    }

    /**
     * Determine of the collection contains a given item.
     *
     * @param  callable|null  $callback
     * @return bool
     */
    public function contains(callable $callback = null): bool
    {
        return ! is_null($this->first($callback));
    }
}
