<?php

namespace Src\Validator\Rules;

class Cnpj
{
    private $value;

    public function __construct($value)
    {
        $this->value = $value;
    }

    public function run()
    {
        return $this->isCnpj($this->value);
    }

    public function isCnpj()
    {
        $c = preg_replace('/\D/', '', $this->value);

        $b = [6, 5, 4, 3, 2, 9, 8, 7, 6, 5, 4, 3, 2];

        if (strlen($c) != 14) {
            return false;

        }

        // Remove sequence repeated with "111111111111"
        elseif (preg_match("/^{$c[0]}{14}$/", $c) > 0) {
            return false;
        }

        for ($i = 0, $n = 0; $i < 12; $n += $c[$i] * $b[++$i]);

        if ($c[12] != ((($n %= 11) < 2) ? 0 : 11 - $n)) {
            return false;
        }

        for ($i = 0, $n = 0; $i <= 12; $n += $c[$i] * $b[$i++]);

        if ($c[13] != ((($n %= 11) < 2) ? 0 : 11 - $n)) {
            return false;
        }

        return true;
    }
}