<?php

namespace Hexlet\Tests\Validator;

use PHPUnit\Framework\TestCase;
use Hexlet\Validator\Validator;

class ValidatorTest extends TestCase
{
    public function testTwoValidator(): void
    {
        $v = new Validator();
        $schema = $v->string();
        $schema2 = $v->string();

        $this->assertTrue($schema->isValid(''));

        $this->assertTrue($schema->isValid(null));

        $this->assertTrue($schema->isValid('what does the fox say'));

        $schema->required();

        $this->assertTrue($schema2->isValid(''));
        $this->assertFalse($schema->isValid(null));
        $this->assertFalse($schema->isValid(''));
        $this->assertTrue($schema->isValid('hexlet'));
    }

    public function testMinLength(): void
    {
        $v = new Validator();
        $schema = $v->string();

        $this->assertTrue($schema->isValid(''));
        $this->assertFalse($schema->minLength(2)->isValid(''));
        $this->assertTrue($schema->minLength(2)->isValid('the'));
        $this->assertFalse($schema->minLength(10)->isValid('the'));
        $this->assertTrue($v->string()->minLength(10)->minLength(5)->isValid('Hexlet'));
    }

    public function testContains(): void
    {
        $v = new Validator();
        $schema = $v->string();

        $this->assertFalse($schema->contains('what')->isValid(''));
        $this->assertTrue($schema->contains('what')->isValid('what does the fox say'));
        $this->assertFalse($schema->contains('whatthe')->isValid('what does the fox say'));
    }
}
