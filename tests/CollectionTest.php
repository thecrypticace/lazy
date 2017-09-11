<?php

namespace Tests;

use PHPUnit\Framework\TestCase;
use TheCrypticAce\Lazy\Collection;

class CollectionTest extends TestCase
{
    use Concerns\Other;
    use Concerns\Tests;
    use Concerns\Arrays;
    use Concerns\Ranges;
    use Concerns\Proxies;
    use Concerns\Functional;
    use Concerns\Statistics;

    /** @test */
    public function helpers_return_correct_collections()
    {
        $this->assertInstanceOf(Collection::class, lazy());
        $this->assertInstanceOf(Collection::class, lazy_range(0, 1));

        $this->assertCount(0, lazy()->all());
        $this->assertCount(2, lazy_range(0, 1)->all());

        $this->assertEquals(new Collection, lazy());
        $this->assertEquals(Collection::range(0, 1), lazy_range(0, 1));
    }

    private function assertCollectionIs($expected, $actual, $message = "")
    {
        $this->assertSame($expected, $actual->toArray(), $message);
    }
}
