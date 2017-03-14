<?php

namespace Tests\Concerns;

use TheCrypticAce\Lazy\Collection;

trait Statistics
{
    /** @test */
    public function average($callback = null)
    {
        $c = $this->collect([(object) ['foo' => 50], (object) ['foo' => 50]]);
        $this->assertEquals(50, $c->average->foo);

        $c = $this->collect([(object) ['foo' => 50], (object) ['foo' => 50]]);
        $this->assertEquals(50, $c->average(function ($i) {
            return $i->foo;
        }));
    }

    /** @test */
    public function a_collection_can_sum_values_from_items()
    {
        $c = $this->collect([(object) ['foo' => 50], (object) ['foo' => 50]]);
        $this->assertEquals(100, $c->sum->foo);

        $c = $this->collect([(object) ['foo' => 50], (object) ['foo' => 50]]);
        $this->assertEquals(100, $c->sum(function ($i) {
            return $i->foo;
        }));
    }

    /** @test */
    public function a_collections_values_can_be_summed()
    {
        $c = $this->collect([1, 2, 3, 4, 5]);
        $this->assertEquals(15, $c->sum());
    }

    /** @test */
    public function an_empty_collection_has_a_sum_of_zero()
    {
        $c = $this->collect();
        $this->assertEquals(0, $c->sum());
        $this->assertEquals(0, $c->sum->foo);
    }

    /** @test */
    public function max()
    {
        $c = $this->collect([(object) ['foo' => 10], (object) ['foo' => 20]]);
        $this->assertEquals(20, $c->max(function ($item) {
            return $item->foo;
        }));
        $this->assertEquals(20, $c->max->foo);

        $c = $this->collect([['foo' => 10], ['foo' => 20]]);
        $this->assertEquals(20, $c->max->foo);

        $c = $this->collect([1, 2, 3, 4, 5]);
        $this->assertEquals(5, $c->max());

        $c = $this->collect();
        $this->assertNull($c->max());
    }

    /** @test */
    public function min()
    {
        $c = $this->collect([(object) ['foo' => 10], (object) ['foo' => 20]]);
        $this->assertEquals(10, $c->min(function ($item) {
            return $item->foo;
        }));
        $this->assertEquals(10, $c->min->foo);

        $c = $this->collect([['foo' => 10], ['foo' => 20]]);
        $this->assertEquals(10, $c->min->foo);

        $c = $this->collect([1, 2, 3, 4, 5]);
        $this->assertEquals(1, $c->min());

        $c = $this->collect();
        $this->assertNull($c->min());
    }
}
