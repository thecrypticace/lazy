<?php

namespace TheCrypticAce\Lazy\Concerns;

trait Statistics
{
    /**
     * Get the average of the given values.
     *
     * @param  ?callable  $callback
     * @return mixed
     */
    public function average(?callable $callback = null)
    {
        $callback = $callback ?? function ($value, $key) {
            return $value;
        };

        $sum = 0;
        $count = 0;

        foreach ($this as $key => $value) {
            $sum += $callback($value, $key);
            $count += 1;
        }

        return $count > 0 ? $sum / $count : null;
    }

    /**
     * Get the sum of the given values.
     *
     * @param  ?callable  $callback
     * @return int
     */
    public function sum(?callable $callback = null): int
    {
        $callback = $callback ?? function ($value, $key) {
            return $value;
        };

        $sum = 0;

        foreach ($this as $key => $value) {
            $sum += $callback($value, $key);
        }

        return $sum;
    }

    /**
     * Get the minimum value in the collection (optionally provided by a callback).
     *
     * @param  ?callable  $callback
     * @return mixed
     */
    public function min(?callable $callback = null)
    {
        $callback = $callback ?? function ($value, $key) {
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
     * Get the maximum value in the collection (optionally provided by a callback).
     *
     * @param  ?callable  $callback
     * @return mixed
     */
    public function max(?callable $callback = null)
    {
        $callback = $callback ?? function ($value, $key) {
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
