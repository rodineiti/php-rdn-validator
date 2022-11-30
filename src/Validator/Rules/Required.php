<?php

namespace Src\Validator\Rules;

class Required
{
    private $value;

    public function __construct($value)
    {
        $this->value = $value;
    }

    public function run()
    {
        return empty($this->value);
    }
}