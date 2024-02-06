<?php

namespace Hexlet\Validator;

class ArrayValidator
{
    protected array $options;

    public function __construct(array $options = [])
    {
        $this->options = array_merge([
            'required' => false,
            'sizeof' => null,
            'shape' => null,
        ], $options);
    }

    public function isValid(?array $array): bool
    {
        if ($this->options['required']) {
            if (!is_array($array)) {
                return false;
            }
        } elseif (is_null($array)) {
            return true;
        }
        if (!is_null($this->options['sizeof'])) {
            if ($this->options['sizeof'] !== count($array)) {
                return false;
            }
        }
        if (!is_null($this->options['shape'])) {
            foreach ($array as $key => $item) {
                if (!$this->options['shape'][$key]->isValid($item)) {
                    return false;
                }
            }
        }
        return true;
    }

    public function required(): ArrayValidator
    {
        $this->options['required'] = true;

        return new self($this->options);
    }

    public function sizeof(int $number): ArrayValidator
    {
        $this->options['sizeof'] = $number;

        return new self($this->options);
    }

    public function shape(array $validators): ArrayValidator
    {
        $this->options['shape'] = $validators;

        return new self($this->options);
    }
}
