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
    public function average($callback = null)
    {
        list($sum, $count) = $this->sumAndCount($callback);

        return $count > 0 ? $sum / $count : null;
    }

    /**
     * Get the sum of the given values.
     *
     * @param  callable|null  $callback
     * @return mixed
     */
    public function sum($callback = null)
    {
        list($sum, $_) = $this->sumAndCount($callback);

        return $sum;
    }

    /**
     * Helper for gathering the sum + count of a series of values
     *
     * @param  callable|null  $callback
     * @return mixed
     */
    private function sumAndCount($callback = null)
    {
        $callback = $callback ?? function ($value) {
            return $value;
        };

        $sum = 0;
        $count = 0;

        foreach ($this->items as $key => $value) {
            $sum += $callback($value, $key);
            $count += 1;
        }

        return [$sum, $count];
    }

    /**
     * Get the min value in the collection (optionally provided by a callback)
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

        foreach ($this->items as $key => $value) {
            $currentValue = $callback($value, $key);

            if ($currentValue < $result || is_null($result)) {
                $result = $currentValue;
            }
        }

        return $result;
    }

    /**
     * Get the max value in the collection (optionally provided by a callback)
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

        foreach ($this->items as $key => $value) {
            $currentValue = $callback($value, $key);

            if ($currentValue > $result || is_null($result)) {
                $result = $currentValue;
            }
        }

        return $result;
    }
}
