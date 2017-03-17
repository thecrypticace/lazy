<?php

namespace Tests\Concerns;

use Illuminate\Support\Collection;
use Illuminate\Contracts\Support\Arrayable;

trait Arrays
{
    /** @test */
    public function toArray()
    {
        $item = new class implements Arrayable {
            public function toArray()
            {
                return [1, 2, 3];
            }
        };

        $c = lazy([$item, $item, $item]);

        $this->assertEquals([[1, 2, 3], [1, 2, 3], [1, 2, 3]], $c->toArray());
    }

    /** @test */
    public function all()
    {
        $c = lazy([1, 2, 3]);

        $this->assertCollectionIs([1, 2, 3], $c);
    }

    /** @test */
    public function lazy_collections_can_be_converted_to_illuminate_collections()
    {
        $c = lazy([1, 2, 3])->collect();

        $this->assertInstanceOf(Collection::class, $c);
    }
}
