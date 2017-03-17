<?php

namespace Tests\Concerns;

trait Functional
{
    /** @test */
    public function map()
    {
        $data = lazy([1, 2, 3]);
        $this->assertCollectionIs([2 + 0, 4 + 1, 6 + 2], $data->map(function ($value, $key) {
            return $value * 2 + $key;
        }));
    }

    /** @test */
    public function keyBy()
    {
        $data = lazy([1, 2, 3]);
        $this->assertCollectionIs([1 => 1, 2 => 2, 3 => 3], $data->keyBy(function ($value, $key) {
            return $value;
        }));
    }

    /** @test */
    public function collapse()
    {
        $data = lazy([[1, 2, 3], [4, 5, 6], [7, 8, 9]]);
        $this->assertCollectionIs([1, 2, 3, 4, 5, 6, 7, 8, 9], $data->collapse()->values());
    }

    /** @test */
    public function flatMap()
    {
        $data = lazy([1, 2, 3]);
        $this->assertCollectionIs([1, 1, 2, 2, 3, 3], $data->flatMap(function ($value, $key) {
            return array_fill(0, 2, $value);
        })->values());
    }

    /** @test */
    public function filter()
    {
        $data = lazy([1, 2, 3, 4, 5, 6]);
        $this->assertCollectionIs([1 => 2, 3 => 4, 5 => 6], $data->filter(function ($value) {
            return $value % 2 === 0;
        }));
    }

    /** @test */
    public function reduce()
    {
        $data = lazy([1, 2, 3]);
        $this->assertEquals(6, $data->reduce(function ($carry, $element) {
            return $carry += $element;
        }));
    }

    /** @test */
    public function accumulate()
    {
        $data = lazy([1, 2, 3]);
        $this->assertCollectionIs([1, 3, 6], $data->accumulate(function ($carry, $element) {
            return $carry += $element;
        }));
    }

    /** @test */
    public function zip()
    {
        $data = lazy([1, 2, 3]);
        $this->assertCollectionIs([[1, 1], [2, 4], [3, 9]], $data->zip([1, 4, 9]));
    }
}
