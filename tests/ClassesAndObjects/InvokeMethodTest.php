<?php

/**
 * Copyright (c) 2015-present Ganbaro Digital Ltd
 * All rights reserved.
 *
 * Redistribution and use in source and binary forms, with or without
 * modification, are permitted provided that the following conditions
 * are met:
 *
 *   * Redistributions of source code must retain the above copyright
 *     notice, this list of conditions and the following disclaimer.
 *
 *   * Redistributions in binary form must reproduce the above copyright
 *     notice, this list of conditions and the following disclaimer in
 *     the documentation and/or other materials provided with the
 *     distribution.
 *
 *   * Neither the names of the copyright holders nor the names of his
 *     contributors may be used to endorse or promote products derived
 *     from this software without specific prior written permission.
 *
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS
 * "AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT
 * LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS
 * FOR A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE
 * COPYRIGHT OWNER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT,
 * INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING,
 * BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES;
 * LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER
 * CAUSED AND ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT
 * LIABILITY, OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN
 * ANY WAY OUT OF THE USE OF THIS SOFTWARE, EVEN IF ADVISED OF THE
 * POSSIBILITY OF SUCH DAMAGE.
 *
 * @category  Libraries
 * @package   UnitTestHelpers/ClassesAndObjects
 * @author    Stuart Herbert <stuherbert@ganbarodigital.com>
 * @copyright 2015-present Ganbaro Digital Ltd www.ganbarodigital.com
 * @license   http://www.opensource.org/licenses/bsd-license.php  BSD License
 * @link      http://code.ganbarodigital.com/php-data-containers
 */

namespace GanbaroDigital\UnitTestHelpers\ClassesAndObjects;

use PHPUnit_Framework_TestCase;

class InvokeMethodTest_TargetClass
{
    private function privateMethod($input)
    {
        return $input * 2;
    }

    protected function protectedMethod($input)
    {
        return $input * 3;
    }

    public function publicMethod($input)
    {
        return $input * 4;
    }

    private static function privateStaticMethod($input)
    {
        return $input * 5;
    }

    protected static function protectedStaticMethod($input)
    {
        return $input * 7;
    }

    public static function publicStaticMethod($input)
    {
        return $input * 11;
    }
}

/**
 * @coversDefaultClass GanbaroDigital\UnitTestHelpers\ClassesAndObjects\InvokeMethod
 */
class InvokeMethodTest extends PHPUnit_Framework_TestCase
{
    /**
     * @covers ::onObject
     */
    public function testCanStaticallyCallPrivateMethods()
    {
        // ----------------------------------------------------------------
        // setup your test

        $target = new InvokeMethodTest_TargetClass;
        $expectedResult = 42;

        // ----------------------------------------------------------------
        // perform the change

        $actualResult = InvokeMethod::onObject($target, 'privateMethod', [ 21 ]);

        // ----------------------------------------------------------------
        // test the results

        $this->assertEquals($expectedResult, $actualResult);
    }

    /**
     * @covers ::onObject
     */
    public function testCanStaticallyCallProtectedMethods()
    {
        // ----------------------------------------------------------------
        // setup your test

        $target = new InvokeMethodTest_TargetClass;
        $expectedResult = 42;

        // ----------------------------------------------------------------
        // perform the change

        $actualResult = InvokeMethod::onObject($target, 'protectedMethod', [ 14 ]);

        // ----------------------------------------------------------------
        // test the results

        $this->assertEquals($expectedResult, $actualResult);
    }

    /**
     * @covers ::onObject
     */
    public function testCanStaticallyCallPublicMethods()
    {
        // ----------------------------------------------------------------
        // setup your test

        $target = new InvokeMethodTest_TargetClass;
        $expectedResult = 40;

        // ----------------------------------------------------------------
        // perform the change

        $actualResult = InvokeMethod::onObject($target, 'publicMethod', [ 10 ]);

        // ----------------------------------------------------------------
        // test the results

        $this->assertEquals($expectedResult, $actualResult);
    }

    /**
     * @coversNone
     */
    public function testCanInstantiate()
    {
        // ----------------------------------------------------------------
        // perform the change

        $obj = new InvokeMethod();

        // ----------------------------------------------------------------
        // test the results

        $this->assertTrue($obj instanceof InvokeMethod);
    }

    /**
     * @covers ::__invoke
     * @dataProvider provideMethodsToCall
     */
    public function testCanUseAsObject($expectedResult, $target, $methodName, $args)
    {
        // ----------------------------------------------------------------
        // setup your test

        $obj    = new InvokeMethod();

        // ----------------------------------------------------------------
        // perform the change

        $actualResult = $obj($target, $methodName, $args);

        // ----------------------------------------------------------------
        // test the results

        $this->assertEquals($expectedResult, $actualResult);
    }

    public function provideMethodsToCall()
    {
        $target = new InvokeMethodTest_TargetClass;
        $tClass = InvokeMethodTest_TargetClass::class;

        return [
            [ 12, $target, 'privateMethod', [ 6 ] ],
            [ 12, $target, 'protectedMethod', [ 4 ] ],
            [ 12, $target, 'publicMethod', [ 3 ] ],
            [ 50, $tClass, 'privateStaticMethod', [ 10 ] ],
            [ 56, $tClass, 'protectedStaticMethod', [ 8 ] ],
            [ 55, $tClass, 'publicStaticMethod', [ 5 ] ]
        ];
    }

    /**
     * @covers ::onClass
     * @covers ::onString
     */
    public function testCanStaticallyCallPrivateStaticMethods()
    {
        // ----------------------------------------------------------------
        // setup your test

        $expectedResult = 50;

        // ----------------------------------------------------------------
        // perform the change

        $actualResult = InvokeMethod::onString(
            InvokeMethodTest_TargetClass::class,
            'privateStaticMethod',
            [ 10 ]
        );

        // ----------------------------------------------------------------
        // test the results

        $this->assertEquals($expectedResult, $actualResult);
    }

    /**
     * @covers ::onClass
     * @covers ::onString
     */
    public function testCanStaticallyCallProtectedStaticMethods()
    {
        // ----------------------------------------------------------------
        // setup your test

        $target = new InvokeMethodTest_TargetClass;
        $expectedResult = 56;

        // ----------------------------------------------------------------
        // perform the change

        $actualResult = InvokeMethod::onString(
            InvokeMethodTest_TargetClass::class,
            'protectedStaticMethod',
            [ 8 ]
        );

        // ----------------------------------------------------------------
        // test the results

        $this->assertEquals($expectedResult, $actualResult);
    }

    /**
     * @covers ::onClass
     * @covers ::onString
     */
    public function testCanStaticallyCallPublicStaticMethods()
    {
        // ----------------------------------------------------------------
        // setup your test

        $target = new InvokeMethodTest_TargetClass;
        $expectedResult = 55;

        // ----------------------------------------------------------------
        // perform the change

        $actualResult = InvokeMethod::onString(
            InvokeMethodTest_TargetClass::class,
            'publicStaticMethod',
            [ 5 ]
        );

        // ----------------------------------------------------------------
        // test the results

        $this->assertEquals($expectedResult, $actualResult);
    }

    /**
     * @covers ::onClass
     * @covers ::onString
     * @expectedException GanbaroDigital\UnitTestHelpers\Exceptions\E4xx_MethodIsNotStatic
     */
    public function testCanOnlyCallStaticMethodsByClass()
    {
        // ----------------------------------------------------------------
        // perform the change

        InvokeMethod::onString(InvokeMethodTest_TargetClass::class, 'publicMethod', []);
    }
}