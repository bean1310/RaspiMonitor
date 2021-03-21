<?php

namespace Tests\Feature\Lib;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Lib\TypeCheck;

class TypeCheckTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testCorrectCaseOfCheckArrayType()
    {
        $stringCorrectCase = [
            'huge',
            'foo',
            'hoge',
            'neko'
        ];
        $this->assertTrue(TypeCheck::checkArrayType('string', $stringCorrectCase));

        $integerCorrectCase = [
            1, 2, 3, 4, 5, 6, 7
        ];
        $this->assertTrue(TypeCheck::checkArrayType('integer', $integerCorrectCase));

        $doubleCorrectCase = [
            1.1, 2.22, 3.333, 4.444
        ];
        $this->assertTrue(TypeCheck::checkArrayType('double', $doubleCorrectCase));

        $arrayCorrectCase = [
            $stringCorrectCase,
            $integerCorrectCase,
            $doubleCorrectCase,
        ];
        $this->assertTrue(TypeCheck::checkArrayType('array', $arrayCorrectCase));
    }

    public function testBadCaseOfCheckArrayType()
    {
        $badCase_mix = [
            'hoo',
            ['hoge'],
            1,
            4.5,
        ];
        $this->assertFalse(TypeCheck::checkArrayType('string', $badCase_mix));
        $this->assertFalse(TypeCheck::checkArrayType('integer', $badCase_mix));
        $this->assertFalse(TypeCheck::checkArrayType('double', $badCase_mix));
        $this->assertFalse(TypeCheck::checkArrayType('array', $badCase_mix));

        $badCase_type = [
            1.1, 2.22, 3.333, 4.444
        ];
        $this->assertFalse(TypeCheck::checkArrayType('string', $badCase_type));

        $badCase_notArray = 'hoge';
        $this->expectException(\TypeError::class);
        TypeCheck::checkArrayType('array', $badCase_notArray);
    }
}
