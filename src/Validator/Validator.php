<?php

namespace Hexlet\Validator;

class Validator
{
    public function string(): StringValidator
    {
        return new StringValidator();
    }

    public function number(): NumberValidator
    {
        return new NumberValidator();
    }
}
