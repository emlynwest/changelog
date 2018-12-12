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

use Codeception\Module\Filesystem;
use Codeception\TestCase\Test;
use InvalidArgumentException;
use PHPUnit_Framework_Error_Warning;

/**
 * Tests for IO\File
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
			['hello', ''],
			$this->file->getContent()
		);
	}

	/**
	 * @expectedException InvalidArgumentException
	 */
	public function testFileNotSet()
	{
		$this->file->getContent();
	}

	public function testSetContent()
	{
		$content = 'foobar';

		$file = __DIR__.'/../../_output/IO-File-testSetContent.txt';
		touch($file);

		$this->file->setConfig(['file' => $file]);
		$this->file->setContent($content);

		/** @var Filesystem $filesystem */
		$filesystem = $this->getModule('Filesystem');
		$filesystem->openFile($file);
		$filesystem->seeInThisFile($content);
		$filesystem->deleteFile($file);
	}
}
