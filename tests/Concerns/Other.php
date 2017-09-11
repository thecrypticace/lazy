<?php

namespace Tests\Concerns;

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
}
