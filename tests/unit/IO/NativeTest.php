<?php
/**
 * PHP Version 5.6
 * @category Library
 * @package ChangeLog
 * @author Emlyn West <emlyn.west@gmail.gom>
 * @license MIT http://opensource.org/licenses/MIT
 * @link https://github.com/emlynwest/changelog
 */

namespace ChangeLog\IO;

use Codeception\TestCase\Test;

/**
 * Tests for IO\String
 */
class StringTest extends Test
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
