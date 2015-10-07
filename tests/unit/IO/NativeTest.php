<?php
/**
 * PHP Version 5.5
 * @category Library
 * @package ChangeLog
 * @author Steve "uru" West <steven.david.west@gmail.com>
 * @license MIT http://opensource.org/licenses/MIT
 * @link https://github.com/stevewest/changelog
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
