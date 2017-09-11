<?php

namespace Tests\Concerns;

use Tests\Stubs\MapIntoStub;

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
    public function mapInto()
    {
        $data = lazy([1, 2, 3]);
        $this->assertCollectionIs([
            new MapIntoStub(1, 0),
            new MapIntoStub(2, 1),
            new MapIntoStub(3, 2),
        ], $data->mapInto(MapIntoStub::class));
    }

    /** @test */
    public function keyBy()
    {
        $data = lazy([1, 2, 3]);
        $this->assertCollectionIs([1 => 1, 2 => 2, 3 => 3], $data->keyBy(function ($value, $key) {
            return $value;
        }));

        $data = lazy([
            ["foo" => 1],
            ["foo" => 2],
        ]);
        $this->assertCollectionIs([1 => ["foo" => 1], 2 => ["foo" => 2]], $data->keyBy->foo);
    }

    /** @test */
    public function keyByValue()
    {
        $data = lazy([1, 2, 3]);
        $this->assertCollectionIs([1 => 1, 2 => 2, 3 => 3], $data->keyByValue());

        // FIXME: Assert keys are arrays
        /*
        $data = lazy([
            ["foo" => 1],
            ["foo" => 2],
        ]);
        $this->assertCollectionIs([["foo" => 1] => ["foo" => 1], ["foo" => 2] => ["foo" => 2]], $data->keyByValue());
        */
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

        $data = lazy([
            ["foo" => [1, 2, 3]],
            ["foo" => [4, 5, 6]],
        ]);

        $this->assertCollectionIs([1, 2, 3, 4, 5, 6], $data->flatMap->foo->values());
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
    public function reject()
    {
        $data = lazy([1, 2, 3, 4, 5, 6]);
        $this->assertCollectionIs([0 => 1, 2 => 3, 4 => 5], $data->reject(function ($value) {
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

    /** @test */
    public function pipe()
    {
        $data = lazy([1, 2, 3]);
        $data = $data->pipe(function ($data) {
            return lazy([2, 3, 4]);
        });

        $this->assertCollectionIs([2, 3, 4], $data);
    }

    /** @test */
    public function pipeThrough()
    {
        $data = lazy([4, 5, 6]);
        $data = $data->pipeThrough([
            function ($data) {
                return $data->append([7, 8, 9]);
            },

            function ($data) {
                return $data->prepend([1, 2, 3]);
            },
        ]);

        $this->assertCollectionIs([1, 2, 3, 4, 5, 6, 7, 8, 9], $data->values());
    }
}
