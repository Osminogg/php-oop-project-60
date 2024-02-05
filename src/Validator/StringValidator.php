<?php

namespace Hexlet\Validator;

class StringValidator
{
    protected array $options;

    public function __construct(array $options = [])
    {
        $this->options = array_merge([
            'required' => false,
            'minLength' => null,
            'contains' => null,
        ], $options);
    }

    public function isValid(?string $string): bool
    {
        if ($this->options['required']) {
            if (is_null($string) || $string === '') {
                return false;
            }
        } elseif (is_null($string)) {
            return true;
        }
        if (!is_null($this->options['minLength'])) {
            if (mb_strlen($string) < $this->options['minLength']) {
                return false;
            }
        }
        if (!is_null($this->options['contains'])) {
            if (mb_strpos($string, $this->options['contains']) === false) {
                return false;
            }
        }
        return true;
    }

    public function required(): StringValidator
    {
        $this->options['required'] = true;

        return new self($this->options);
    }

    public function minLength(int $number): StringValidator
    {
        $this->options['minLength'] = $number;

        return new self($this->options);
    }

    public function contains(string $string): StringValidator
    {
        $this->options['contains'] = $string;

        return new self($this->options);
    }
}
