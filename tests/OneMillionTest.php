<?php

use PHPUnit\Framework\TestCase;

class OneMillionTest extends TestCase
{
    /** @test */
    public function operate_on_one_million_numbers_eagerly()
    {
        $calls = 0;

        $n = collect(range(1, 1000000))

        ->filter(function ($n) use (&$calls) {
            $calls += 1;

            return $n % 2 === 0;
        })
        ->map(function ($n) use (&$calls) {
            $calls += 1;

            return $n / 4;
        })
        ->filter(function ($n) use (&$calls) {
            $calls += 1;

            return $n >= 100;
        })
        ->first();

        $this->assertEquals($n, 100);
        $this->assertEquals($calls, 2000000);
    }

    /** @test */
    public function operate_on_one_million_numbers_somewhat_lazily()
    {
        $calls = 0;

        $n = lazy(range(1, 1000000))

        ->filter(function ($n) use (&$calls) {
            $calls += 1;

            return $n % 2 === 0;
        })

        ->map(function ($n) use (&$calls) {
            $calls += 1;

            return $n / 4;
        })

        ->filter(function ($n) use (&$calls) {
            $calls += 1;

            return $n >= 100;
        })
        ->first();

        $this->assertEquals($n, 100);
        $this->assertEquals($calls, 800);
    }

    /** @test */
    public function operate_on_one_million_numbers_lazily()
    {
        $calls = 0;

        $n = lazy_range(1, 1000000)

        ->filter(function ($n) use (&$calls) {
            $calls += 1;

            return $n % 2 === 0;
        })
        ->map(function ($n) use (&$calls) {
            $calls += 1;

            return $n / 4;
        })
        ->filter(function ($n) use (&$calls) {
            $calls += 1;

            return $n >= 100;
        })
        ->first();

        $this->assertEquals($n, 100);
        $this->assertEquals($calls, 800);
    }
}
