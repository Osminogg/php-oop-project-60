<?php

namespace Hexlet\Validator;

class Validator
{
    protected array $validators;

    public function __construct()
    {
        $this->validators = [
            'string' => [],
            'number' => []
        ];
    }

    public function string(): StringValidator
    {
        return new StringValidator([], $this->validators['string']);
    }

    public function number(): NumberValidator
    {
        return new NumberValidator([], $this->validators['number']);
    }

    public function array(): ArrayValidator
    {
        return new ArrayValidator();
    }

    public function addValidator(string $type, string $name, callable $fn): void
    {
        if (isset($this->validators[$type])) {
            $this->validators[$type][$name] = $fn;
        } else {
            throw new \Exception("boom!");
        }
    }
}
