<?php

namespace Tests\Concerns;

use TheCrypticAce\Lazy\Collection;

trait Tests
{
    /** @test */
    public function first_returns_first_item_in_collection()
    {
        $c = lazy(["foo", "bar"]);
        $this->assertEquals("foo", $c->first());
    }

    /** @test */
    public function first_with_callback()
    {
        $data = lazy(["foo", "bar", "baz"]);
        $result = $data->first(function ($value) {
            return $value === "bar";
        });
        $this->assertEquals("bar", $result);
    }

    /** @test */
    public function first_with_callback_and_default()
    {
        $data = lazy(["foo", "bar"]);
        $result = $data->first(function ($value) {
            return $value === "baz";
        }, "default");
        $this->assertEquals("default", $result);
    }

    /** @test */
    public function first_with_default_and_without_callback()
    {
        $data = lazy();
        $result = $data->first(null, "default");
        $this->assertEquals("default", $result);
    }

    /** @test */
    public function last_returns_last_item_in_collection()
    {
        $c = lazy(["foo", "bar"]);

        $this->assertEquals("bar", $c->last());
    }

    /** @test */
    public function last_with_callback()
    {
        $data = lazy([100, 200, 300]);
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
    public function last_with_callback_and_default()
    {
        $data = lazy(["foo", "bar"]);
        $result = $data->last(function ($value) {
            return $value === "baz";
        }, "default");
        $this->assertEquals("default", $result);
    }

    /** @test */
    public function last_with_default_and_without_callback()
    {
        $data = lazy();
        $result = $data->last(null, "default");
        $this->assertEquals("default", $result);
    }

    /** @test */
    public function contains_determines_availability_in_collection(callable $callback = null)
    {
        $c = lazy(["a", "b", "c"]);

        $this->assertTrue($c->contains(function ($value) {
            return $value === "a";
        }));

        $c = lazy([["foo" => true], ["foo" => false]]);
        $this->assertTrue($c->contains->foo);

        $c = lazy([["foo" => false], ["foo" => false]]);
        $this->assertFalse($c->contains->foo);
    }
}
