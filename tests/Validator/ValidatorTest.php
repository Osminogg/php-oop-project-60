<?php

namespace Hexlet\Tests\Validator;

use PHPUnit\Framework\TestCase;
use Hexlet\Validator\Validator;

class ValidatorTest extends TestCase
{
    public function testAddValidator(): void
    {
        $v = new Validator();

        $this->expectException(\Exception::class);

        $fn = fn() => true;
        $v->addValidator('wrong-name', 'startWith', $fn);
    }
}
