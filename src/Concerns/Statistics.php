<?php

namespace TheCrypticAce\Lazy\Concerns;

trait Statistics
{
    /**
     * Get the average of the given values.
     *
     * @param  callable|null  $callback
     * @return mixed
     */
    public function average(callable $callback = null)
    {
        $count = 0;

        $sum = $this->map(function ($value) use (&$count) {
            $count += 1;

            return $value;
        })->sum($callback);

        return $count > 0 ? $sum / $count : null;
    }

    /**
     * Get the sum of the given values.
     *
     * @param  callable|null  $callback
     * @return int
     */
    public function sum($callback = null): int
    {
        $callback = $callback ?? function ($value) {
            return $value;
        };

        $sum = 0;

        foreach ($this as $key => $value) {
            $sum += $callback($value, $key);
        }

        return $sum;
    }

    /**
     * Get the min value in the collection (optionally provided by a callback).
     *
     * @param  callable|null  $callback
     * @return mixed
     */
    public function min($callback = null)
    {
        $callback = $callback ?? function ($value) {
            return $value;
        };

        $result = null;

        foreach ($this as $key => $value) {
            $currentValue = $callback($value, $key);

            if ($currentValue < $result || is_null($result)) {
                $result = $currentValue;
            }
        }

        return $result;
    }

    /**
     * Get the max value in the collection (optionally provided by a callback).
     *
     * @param  callable|null  $callback
     * @return mixed
     */
    public function max($callback = null)
    {
        $callback = $callback ?? function ($value) {
            return $value;
        };

        $result = null;

        foreach ($this as $key => $value) {
            $currentValue = $callback($value, $key);

            if ($currentValue > $result || is_null($result)) {
                $result = $currentValue;
            }
        }

        return $result;
    }
}
