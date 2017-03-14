<?php

namespace TheCrypticAce\Lazy\Concerns;

trait Range
{
    /**
     * Generate a range of numbers on-demand.
     *
     * @return static
     */
    public static function range($start, $end, $step = 1)
    {
        assert($start <= $end);
        assert($step <= ($end - $start));

        return new static(function () use ($start, $end, $step) {
            for ($i = $start; $i <= $end; $i += $step) {
                if ($i > $end) {
                    continue;
                }

                yield $i;
            }
        });
    }
}
