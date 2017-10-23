<?php

namespace TheCrypticAce\Lazy\Concerns;

trait Range
{
    /**
     * Generate a range of numbers on-demand.
     *
     * @param int|double $start
     * @param int|double $end
     * @param int|double $step
     * @return static
     */
    public static function range($start, $end, $step = 1): self
    {
        assert($start <= $end);
        assert($step <= ($end - $start));

        return new static(function () use ($start, $end, $step) {
            for ($i = $start; $i <= $end; $i += $step) {
                yield $i;
            }
        });
    }
}
