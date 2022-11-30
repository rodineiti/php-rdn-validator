<?php

namespace Src\Validator\Rules;

class Cpf
{
    private $value;

    public function __construct($value)
    {
        $this->value = $value;
    }

    public function run()
    {
        return $this->isCpf($this->value);
    }

    public function isCpf()
    {
        $c = preg_replace('/\D/', '', $this->value);

        if (strlen($c) != 11 || preg_match("/^{$c[0]}{11}$/", $c)) {
            return false;
        }

        for ($s = 10, $n = 0, $i = 0; $s >= 2; $n += $c[$i++] * $s--);

        if ($c[9] != ((($n %= 11) < 2) ? 0 : 11 - $n)) {
            return false;
        }

        for ($s = 11, $n = 0, $i = 0; $s >= 2; $n += $c[$i++] * $s--);

        if ($c[10] != ((($n %= 11) < 2) ? 0 : 11 - $n)) {
            return false;
        }

        return true;
    }
}