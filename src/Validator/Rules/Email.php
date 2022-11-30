<?php

namespace Src\Validator\Rules;

class Email
{
    private $value;

    public function __construct($value)
    {
        $this->value = $value;
    }

    public function run()
    {
        return filter_var($this->value, FILTER_VALIDATE_EMAIL);
    }
}