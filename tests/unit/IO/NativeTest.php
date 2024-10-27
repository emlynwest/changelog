<?php
/**
 * @category Library
 * @license MIT http://opensource.org/licenses/MIT
 * @link https://github.com/emlynwest/changelog
 */

namespace ChangeLog\IO;

use Codeception\Test\Unit;

/**
 * Tests for IO\String
 */
class StringTest extends Unit
{

	public function testGetSetContent()
	{
		$content = ['foo'];
		$string = new Native($content);

		$this->assertEquals(
			$content,
			$string->getContent()
		);

		$string = new Native;
		$string->setContent("baz\nbat");
		$this->assertEquals(
			['baz', 'bat'],
			$string->getContent()
		);
	}

}
