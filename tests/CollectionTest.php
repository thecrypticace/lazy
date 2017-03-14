<?php

namespace Tests;

use PHPUnit\Framework\TestCase;
use TheCrypticAce\Lazy\Collection;
use Illuminate\Contracts\Support\Arrayable;

class CollectionTest extends TestCase
{
    use Concerns\Other;
    use Concerns\Tests;
    use Concerns\Arrays;
    use Concerns\Ranges;
    use Concerns\Functional;
    use Concerns\Statistics;

    private function collect($data = [])
    {
        return new Collection($data);
    }

    private function collection()
    {
        return new Collection();
    }

    private function assertCollectionIs($expected, $actual, $message = "")
    {
        $this->assertEquals($expected, $actual->toArray(), $message);
    }
}
