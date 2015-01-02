<?php
/**
 * PHP Version 5.5
 * @category Library
 * @package ChangeLog
 * @author Steve "uru" West <uruwolf@gmail.com>
 * @license MIT http://opensource.org/licenses/MIT
 * @link https://github.com/stevewest/changelog
 */

namespace ChangeLog\Provider;

use Codeception\TestCase\Test;
use InvalidArgumentException;

/**
 * Tests for Provider\File
 */
class FileTest extends Test
{

	/**
	 * @var File
	 */
	protected $file;

	protected function _before()
	{
		$this->file = new File;
	}

	public function testLoadFile()
	{
		$this->file->setConfig([
			'file' => __DIR__.'/../../resources/hello'
		]);

		$this->assertEquals(
			'hello',
			$this->file->nextLine()
		);

		$this->assertEquals(
			'',
			$this->file->nextLine()
		);

		$this->assertNull(
			$this->file->nextLine()
		);
	}

	/**
	 * @expectedException InvalidArgumentException
	 */
	public function testFileNotSet()
	{
		$this->file->nextLine();
	}

	/**
	 * @expectedException InvalidArgumentException
	 */
	public function testInvalidFile()
	{
		$this->file->setConfig(['file' => 'foobar']);
		$this->file->nextLine();
	}

}
