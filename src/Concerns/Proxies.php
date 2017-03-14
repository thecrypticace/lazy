<?php

namespace TheCrypticAce\Lazy\Concerns;

use Exception;
use TheCrypticAce\Lazy\Collection;
use TheCrypticAce\Lazy\HigherOrderCollectionProxy;

trait Proxies
{
    /**
     * The methods that can be proxied.
     *
     * @var array
     */
    protected static $proxies = [
        // Functional
        "reduce", "accumulate",
        "map", "filter", "each",

        // Statistics
        "sum", "min", "max", "average",

        // Tests
        "contains",
    ];

    /**
     * Add a method to the list of proxied methods.
     *
     * @param  string  $method
     * @return void
     */
    public static function proxy($method)
    {
        static::$proxies[] = $method;
    }

    /**
     * Dynamically access collection proxies.
     *
     * @param  string  $key
     * @return mixed
     *
     * @throws \Exception
     */
    public function __get($key)
    {
        if (! in_array($key, static::$proxies, true)) {
            throw new Exception("Property [{$key}] does not exist on this collection instance.");
        }

        return new HigherOrderCollectionProxy($this, $key);
    }
}
