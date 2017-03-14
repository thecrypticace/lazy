<?php

namespace TheCrypticAce\Lazy\Concerns;

trait Statistics
{
    /**
     * Get the average of the given values.
     *
     * @param  callable|string|null  $callback
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
     * @param  callable|string|null  $callback
     * @return mixed
     */
    public function sum($callback = null)
    {
        list($sum, $_) = $this->sumAndCount($callback);

        return $sum;
    }

    /**
     * Alias for the "avg" method.
     *
     * @param  callable|string|null  $callback
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
     * Get the min value of a given key.
     *
     * @param  callable|string|null  $callback
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
     * Get the max value of a given key.
     *
     * @param  callable|string|null  $callback
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
