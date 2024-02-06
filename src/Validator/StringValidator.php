<?php

namespace Hexlet\Validator;

class StringValidator
{
    protected array $options;
    protected array $validators;

    public function __construct(array $options = [], array $validators = [])
    {
        $this->validators = $validators;
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
        if (count($this->validators) > 0) {
            foreach ($this->validators as $key => $validator) {
                if (isset($this->options[$key]) && !$validator($string, $this->options[$key])) {
                    return false;
                }
            }
        }
        return true;
    }

    public function required(): StringValidator
    {
        $this->options['required'] = true;

        return new self($this->options, $this->validators);
    }

    public function minLength(int $number): StringValidator
    {
        $this->options['minLength'] = $number;

        return new self($this->options, $this->validators);
    }

    public function contains(string $string): StringValidator
    {
        $this->options['contains'] = $string;

        return new self($this->options, $this->validators);
    }

    public function test(string $name, string $value): StringValidator
    {
        $this->options[$name] = $value;

        return new self($this->options, $this->validators);
    }
}
