<?php

namespace Hexlet\Tests\Validator;

use PHPUnit\Framework\TestCase;
use Hexlet\Validator\Validator;

class NumberValidatorTest extends TestCase
{
    public function testValidator(): void
    {
        $v = new Validator();
        $schema = $v->number();

        $this->assertTrue($schema->isValid(null));

        $schema->required();

        $this->assertFalse($schema->isValid(null));
        $this->assertTrue($schema->isValid(4));
    }

    public function testPositive(): void
    {
        $v = new Validator();
        $schema = $v->number();
        $schema2 = $v->number();

        $schema->positive();

        $this->assertTrue($schema->isValid(2));
        $this->assertFalse($schema->isValid(-2));
        $this->assertFalse($schema->isValid(0));
        $this->assertTrue($schema2->positive()->isValid(10));
    }

    public function testRange(): void
    {
        $v = new Validator();
        $schema = $v->number();
        $schema2 = $v->number();

        $schema->required();
        $schema->range(-5, 5);

        $this->assertTrue($schema->isValid(2));
        $this->assertTrue($schema->isValid(-5));
        $this->assertTrue($schema->isValid(5));
        $this->assertFalse($schema->isValid(10));
        $this->assertFalse($schema->isValid(-10));

        $this->assertTrue($schema2->positive()->isValid(10));
        $schema2->range(-3, 3);
        $this->assertFalse($schema2->isValid(-2));
        $this->assertTrue($schema2->isValid(2));
    }

    public function testAddValidator(): void
    {
        $v = new Validator();
        $fn = fn($value, $min) => $value >= $min;
        $v->addValidator('number', 'min', $fn);

        $schema = $v->number()->test('min', 5);
        $this->assertFalse($schema->isValid(4));
        $this->assertTrue($schema->isValid(6));
    }
}
