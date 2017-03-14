<?php

namespace Tests\Concerns;

use TheCrypticAce\Lazy\Collection;

trait Tests
{
    /** @test */
    public function firstReturnsFirstItemInCollection()
    {
        $c = $this->collect(['foo', 'bar']);
        $this->assertEquals('foo', $c->first());
    }

    /** @test */
    public function firstWithCallback()
    {
        $data = $this->collect(["foo", "bar", "baz"]);
        $result = $data->first(function ($value) {
            return $value === "bar";
        });
        $this->assertEquals("bar", $result);
    }

    /** @test */
    public function firstWithCallbackAndDefault()
    {
        $data = $this->collect(["foo", "bar"]);
        $result = $data->first(function ($value) {
            return $value === "baz";
        }, "default");
        $this->assertEquals("default", $result);
    }

    /** @test */
    public function firstWithDefaultAndWithoutCallback()
    {
        $data = new Collection;
        $result = $data->first(null, "default");
        $this->assertEquals("default", $result);
    }

    /** @test */
    public function lastReturnsLastItemInCollection()
    {
        $c = $this->collect(['foo', 'bar']);

        $this->assertEquals('bar', $c->last());
    }

    /** @test */
    public function lastWithCallback()
    {
        $data = $this->collect([100, 200, 300]);
        $result = $data->last(function ($value) {
            return $value < 250;
        });
        $this->assertEquals(200, $result);
        $result = $data->last(function ($value, $key) {
            return $key < 2;
        });
        $this->assertEquals(200, $result);
    }

    /** @test */
    public function lastWithCallbackAndDefault()
    {
        $data = $this->collect(['foo', 'bar']);
        $result = $data->last(function ($value) {
            return $value === 'baz';
        }, 'default');
        $this->assertEquals('default', $result);
    }

    /** @test */
    public function lastWithDefaultAndWithoutCallback()
    {
        $data = $this->collect();
        $result = $data->last(null, 'default');
        $this->assertEquals('default', $result);
    }
}
