<?php
/**
 * @category Library
 * @license MIT http://opensource.org/licenses/MIT
 * @link https://github.com/emlynwest/changelog
 */

namespace ChangeLog\IO;

use Codeception\Module\Filesystem;
use Codeception\Test\Unit;
use InvalidArgumentException;

/**
 * Tests for IO\File
 */
class FileTest extends Unit
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
		$fileLocation = __DIR__ . '/../../_output/hello';
		@unlink ($fileLocation);

		file_put_contents($fileLocation, "hello\n");

		$this->file->setConfig([
			'file' => $fileLocation,
		]);

		$this->assertEquals(
			['hello', ''],
			$this->file->getContent()
		);
	}

	public function testFileNotSet()
	{
		$this->expectException(InvalidArgumentException::class);
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
