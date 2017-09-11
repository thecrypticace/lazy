<?php

namespace Tests\Stubs;

class MapIntoStub
{
    public $key;
    public $value;

    public function __construct($value, $key)
    {
        $this->key = $key;
        $this->value = $value;
    }
}
