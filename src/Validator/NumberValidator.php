<?php

namespace Hexlet\Validator;

class NumberValidator
{
    protected array $options;
    protected array $validators;

    public function __construct(array $options = [], array $validators = [])
    {
        $this->validators = $validators;
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
        if (count($this->validators) > 0) {
            foreach ($this->validators as $key => $validator) {
                if (isset($this->options[$key]) && !$validator($number, $this->options[$key])) {
                    return false;
                }
            }
        }
        return true;
    }

    public function required(): NumberValidator
    {
        $this->options['required'] = true;

        return new self($this->options, $this->validators);
    }

    public function positive(): NumberValidator
    {
        $this->options['positive'] = true;

        return new self($this->options, $this->validators);
    }

    public function range(int $min, int $max): NumberValidator
    {
        $this->options['range'] = [$min, $max];

        return new self($this->options, $this->validators);
    }

    public function test(string $name, int $value): NumberValidator
    {
        $this->options[$name] = $value;

        return new self($this->options, $this->validators);
    }
}
