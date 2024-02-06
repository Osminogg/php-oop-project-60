<?php

namespace Hexlet\Tests\Validator;

use PHPUnit\Framework\TestCase;
use Hexlet\Validator\Validator;

class ArrayValidatorTest extends TestCase
{
    public function testValidator(): void
    {
        $v = new Validator();
        $schema = $v->array();

        $this->assertTrue($schema->isValid(null));

        $schema->required();

        $this->assertFalse($schema->isValid(null));
        $this->assertTrue($schema->isValid([]));
        $this->assertTrue($schema->isValid(['hexlet', 'test']));
    }

    public function testSizeof(): void
    {
        $v = new Validator();
        $schema = $v->array();

        $schema->sizeof(2);

        $this->assertFalse($schema->isValid(['hexlet']));
        $this->assertTrue($schema->isValid(['hexlet', 'code-basics']));
    }

    public function testShape(): void
    {
        $v = new Validator();
        $schema = $v->array();

        $schema->shape([
            'name' => $v->string()->required(),
            'age' => $v->number()->positive(),
        ]);

        $this->assertTrue($schema->isValid(['name' => 'kolya', 'age' => 100]));
        $this->assertTrue($schema->isValid(['name' => 'maya', 'age' => null]));
        $this->assertFalse($schema->isValid(['name' => '', 'age' => null]));
        $this->assertFalse($schema->isValid(['name' => 'ada', 'age' => -5]));
    }
}
