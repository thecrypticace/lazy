<?php

namespace Tests\Concerns;

use stdClass;

trait Other
{
    /** @test */
    public function keys()
    {
        $c = lazy(["a" => "foo", "b" => "bar"]);
        $this->assertCollectionIs(["a", "b"], $c->keys());
    }

    /** @test */
    public function values()
    {
        $c = lazy(["a" => "foo", "b" => "bar"]);
        $this->assertCollectionIs(["foo", "bar"], $c->values());
    }

    /** @test */
    public function each()
    {
        $c = lazy([1, 2, 3, 4, 5]);

        $result = [];

        $c->each(function ($value, $key) use (&$result) {
            $result[] = "{$key}-{$value}";
        });

        $this->assertEquals(["0-1", "1-2", "2-3", "3-4", "4-5"], $result);
    }

    /** @test */
    public function chunk()
    {
        $result = lazy()->chunk(1);
        $this->assertCollectionIs([], $result);

        $result = lazy([1])->chunk(1);
        $this->assertCollectionIs([[1]], $result);

        $result = lazy([1, 2, 3])->chunk(1);
        $this->assertCollectionIs([[1], [2], [3]], $result);

        $result = lazy()->chunk(2);
        $this->assertCollectionIs([], $result);

        $result = lazy([1])->chunk(2);
        $this->assertCollectionIs([[1]], $result);

        $result = lazy([1, 2, 3])->chunk(2);
        $this->assertCollectionIs([[1, 2], [3]], $result);

        $result = lazy()->chunk(PHP_INT_MAX);
        $this->assertCollectionIs([], $result);

        $result = lazy([1])->chunk(PHP_INT_MAX);
        $this->assertCollectionIs([[1]], $result);

        $result = lazy([1, 2, 3])->chunk(PHP_INT_MAX);
        $this->assertCollectionIs([[1, 2, 3]], $result);
    }

    /** @test */
    public function prepend()
    {
        $data = lazy([1, 2, 3]);
        $this->assertCollectionIs([4, 5, 6, 1, 2, 3], $data->prepend([4, 5, 6])->values());
    }

    /** @test */
    public function append()
    {
        $data = lazy([1, 2, 3]);
        $this->assertCollectionIs([1, 2, 3, 4, 5, 6], $data->append([4, 5, 6])->values());
    }

    /** @test */
    public function when()
    {
        $data = lazy([1, 2, 3]);
        $data = $data->when(true, function () {
            return lazy([2, 3, 4]);
        });

        $this->assertCollectionIs([2, 3, 4], $data);

        $data = lazy([1, 2, 3]);
        $data = $data->when(function () {
            return true;
        }, function () {
            return lazy([2, 3, 4]);
        });

        $this->assertCollectionIs([2, 3, 4], $data);

        $data = lazy([1, 2, 3]);
        $data = $data->when(false, function () {
            return lazy([2, 3, 4]);
        });

        $this->assertCollectionIs([1, 2, 3], $data);

        $data = lazy([1, 2, 3]);
        $data = $data->when(function () {
            return false;
        }, function () {
            return lazy([2, 3, 4]);
        });

        $this->assertCollectionIs([1, 2, 3], $data);
    }

    /** @test */
    public function during()
    {
        $result = 0;

        $data = lazy([1, 2, 3]);
        $data = $data->during(function ($value, $key) use (&$result) {
            $result += $value + $key;
        });

        $this->assertEquals(0, $result);

        $this->assertCollectionIs([1, 2, 3], $data);
        $this->assertEquals(9, $result);
    }

    /** @test */
    public function tap()
    {
        $called = false;

        $data = lazy([1, 2, 3]);
        $data = $data->tap(function ($collection) use ($data, &$called) {
            $this->assertSame($collection, $data);

            $called = true;
        });


        $this->assertTrue($called);
        $this->assertCollectionIs([1, 2, 3], $data);
    }

    /** @test */
    public function unique()
    {
        $data = lazy([1, 1, 2, 3, 3, 4]);
        $data = $data->unique();

        $this->assertCollectionIs([0 => 1, 2 => 2, 3 => 3, 5 => 4], $data);

        $data = lazy([
            $o1 = new stdClass,
            $o1,
            $o2 = new stdClass,
            $o3 = new stdClass,
            $o3,
            $o4 = new stdClass,
        ]);
        $data = $data->unique();

        $this->assertCollectionIs([0 => $o1, 2 => $o2, 3 => $o3, 5 => $o4], $data);

        $data = lazy([1, 1, 2, 3, 3, 4]);
        $data = $data->unique(function ($value) {
            return ceil(sqrt($value));
        });

        $this->assertCollectionIs([0 => 1, 2 => 2], $data);

        $data = lazy([1, 1, 2, 3, 3, 4]);
        $data = $data->unique(function ($value, $key) {
            return ceil(sqrt($key));
        });

        $this->assertCollectionIs([0 => 1, 1 => 1, 2 => 2, 5 => 4], $data);

        $data = lazy([
            ["id" => 1],
            ["id" => 2],
            ["id" => 1],
            ["id" => 3],
            ["id" => 1],
            ["id" => 4],
        ]);
        $data = $data->unique(function ($value) {
            return $value["id"];
        });

        $this->assertCollectionIs([
            0 => ["id" => 1],
            1 => ["id" => 2],
            3 => ["id" => 3],
            5 => ["id" => 4],
        ], $data);

        $data = lazy([
            ["id" => 1],
            ["id" => 2],
            ["id" => 1],
            ["id" => 3],
            ["id" => 1],
            ["id" => 4],
        ]);
        $data = $data->unique->id;

        $this->assertCollectionIs([
            0 => ["id" => 1],
            1 => ["id" => 2],
            3 => ["id" => 3],
            5 => ["id" => 4],
        ], $data);
    }
}
