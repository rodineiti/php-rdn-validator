<?php

namespace RdnValidator\Validator\Rules;

class Required
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
     * @return bool
     */
    public function run()
    {
        return empty($this->value);
    }
}