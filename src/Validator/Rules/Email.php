<?php

namespace RdnValidator\Validator\Rules;

class Email
{
    /**
     * @var
     */
    private $value;

    /**
     * @param $value
     */
    public function __construct($value)
    {
        $this->value = $value;
    }

    /**
     * @return mixed
     */
    public function run()
    {
        return filter_var($this->value, FILTER_VALIDATE_EMAIL);
    }
}