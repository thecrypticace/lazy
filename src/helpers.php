<?php

use TheCrypticAce\Lazy\Collection;

if (! function_exists("lazy")) {
    /**
     * Create a collection from the given value.
     *
     * @param  mixed  $value
     * @return \TheCrypticAce\Lazy\Collection
     */
    function lazy($value = null)
    {
        return new Collection($value);
    }
}

if (! function_exists("lazy_range")) {
    /**
     * Return a lazily-generated range of numbers staring from `$start`
     * to `$end` where the difference between each element is `$step`.
     *
     * @param  int|float  $start
     * @param  int|float  $end
     * @param  int|float  $step
     * @return \TheCrypticAce\Lazy\Collection
     */
    function lazy_range($start, $end, $step = 1)
    {
        return Collection::range($start, $end, $step);
    }
}
