<?php

namespace Tests\Concerns;

use TheCrypticAce\Lazy\Collection;

trait Other
{
    /** @test */
    public function keys()
    {
        $c = $this->collect(["a" => "foo", "b" => "bar"]);
        $this->assertCollectionIs(["a", "b"], $c->keys());
    }

    /** @test */
    public function values()
    {
        $c = $this->collect(["a" => "foo", "b" => "bar"]);
        $this->assertCollectionIs(["foo", "bar"], $c->values());
    }

    /** @test */
    public function each()
    {
        $c = $this->collect([1, 2, 3, 4, 5]);

        $result = [];

        $c->each(function ($value, $key) use (&$result) {
            $result[] = "{$key}-{$value}";
        });

        $this->assertEquals(["0-1", "1-2", "2-3", "3-4", "4-5"], $result);
    }
}
