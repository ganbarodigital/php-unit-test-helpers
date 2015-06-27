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
 * @package   GanbaroDigital/UnitTestHelpers
 * @author    Stuart Herbert <stuherbert@ganbarodigital.com>
 * @copyright 2015-present Ganbaro Digital Ltd www.ganbarodigital.com
 * @license   http://www.opensource.org/licenses/bsd-license.php  BSD License
 * @link      http://code.ganbarodigital.com/php-data-containers
 */

namespace GanbaroDigital\UnitTestHelpers\Objects;

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
}

/**
 * @coversDefaultClass GanbaroDigital\UnitTestHelpers\Objects\InvokeMethod
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
	 */
	public function testCanUseAsObject()
	{
	    // ----------------------------------------------------------------
	    // setup your test

	    $obj    = new InvokeMethod();
	    $target = new InvokeMethodTest_TargetClass();
	    $expectedResult = 12;

	    // ----------------------------------------------------------------
	    // perform the change

	    $actualResult1 = $obj($target, 'privateMethod', [ 6 ]);
	    $actualResult2 = $obj($target, 'protectedMethod', [ 4 ]);
	    $actualResult3 = $obj($target, 'publicMethod', [ 3 ]);

	    // ----------------------------------------------------------------
	    // test the results

	    $this->assertEquals($expectedResult, $actualResult1);
	    $this->assertEquals($expectedResult, $actualResult2);
	    $this->assertEquals($expectedResult, $actualResult3);
	}

}