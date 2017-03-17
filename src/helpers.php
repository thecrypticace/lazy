<?php

use TheCrypticAce\Lazy\Collection;

if (! function_exists('lazy')) {
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

if (! function_exists('lazy_range')) {
    /**
     * Create a collection from the given value.
     *
     * @param  mixed  $value
     * @return \TheCrypticAce\Lazy\Collection
     */
    function lazy_range($start, $end, $step = 1)
    {
        return Collection::range($start, $end, $step);
    }
}
