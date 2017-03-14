<?php

namespace Tests\Concerns;

trait Ranges
{
    /** @test */
    public function range()
    {
        $c = $this->collection()->range(1, 10);
        $this->assertCollectionIs([1, 2, 3, 4, 5, 6, 7, 8, 9, 10], $c);

        $c = $this->collection()->range(0, 10, 2);
        $this->assertCollectionIs([0, 2, 4, 6, 8, 10], $c);

        $c = $this->collection()->range(0, 10, 3);
        $this->assertCollectionIs([0, 3, 6, 9], $c);
    }
}
