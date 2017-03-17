<?php

namespace Tests\Concerns;

use TheCrypticAce\Lazy\Collection;

trait Proxies
{
    /**
     * @test
     * @expectedException \Exception
     * @expectedExceptionMessage Property [foo] does not exist on this collection instance.
     **/
    public function using_higher_order_messages_on_unproxied_methods_fails()
    {
        lazy()->foo->bar;
    }

    /** @!test **/
    public function users_can_add_proxies_to_lazy_collections()
    {
        lazy()->proxy("foo");
    }
}
