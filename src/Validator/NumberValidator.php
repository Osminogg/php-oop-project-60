<?php

namespace Hexlet\Validator;

class NumberValidator
{
    protected array $options;

    public function __construct(array $options = [])
    {
        $this->options = array_merge([
            'required' => false,
            'positive' => false,
            'range' => null,
        ], $options);
    }

    public function isValid(?int $number): bool
    {
        if ($this->options['required']) {
            if (is_null($number)) {
                return false;
            }
        } elseif (is_null($number)) {
            return true;
        }
        if ($this->options['positive']) {
            if ($number <= 0) {
                return false;
            }
        }
        if (!is_null($this->options['range'])) {
            [$min, $max] = $this->options['range'];
            if ($min > $max) {
                return false;
            }
            if ($min > $number || $max < $number) {
                return false;
            }
        }
        return true;
    }

    public function required(): NumberValidator
    {
        $this->options['required'] = true;

        return new self($this->options);
    }

    public function positive(): NumberValidator
    {
        $this->options['positive'] = true;

        return new self($this->options);
    }

    public function range(int $min, int $max): NumberValidator
    {
        $this->options['range'] = [$min, $max];

        return new self($this->options);
    }
}
