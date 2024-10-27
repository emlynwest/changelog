<?php
/**
 * @category Library
 * @license MIT http://opensource.org/licenses/MIT
 * @link https://github.com/emlynwest/changelog
 */

namespace ChangeLog\IO;

use Codeception\Test\Unit;
use InvalidArgumentException;

/**
 * Tests for IO\Flysystem
 */
class FlysystemTest extends Unit
{

	/**
	 * @var Flysystem
	 */
	protected $file;

	protected function _before()
	{
		$this->file = new Flysystem;
	}

	public function testLoadFile()
	{
		$filesystem = \Mockery::mock('League\Flysystem\Filesystem');
		$filesystem->shouldReceive('read')
			->with('hello.txt')
			->once()
			->andReturn("hello\n");

		$this->file->setConfig([
			'file' => 'hello.txt',
			'filesystem' => $filesystem,
		]);

		$this->assertEquals(
			['hello', ''],
			$this->file->getContent()
		);
	}

	public function testFileNotSet()
	{
		$this->expectException(InvalidArgumentException::class);
		$this->expectExceptionMessage('File not specified.');

		$filesystem = \Mockery::mock('League\Flysystem\Filesystem');
		$this->file->setConfig([
			'filesystem' => $filesystem,
		]);
		$this->file->getContent();
	}

	public function testFilesystemNotSet()
	{
		$this->expectException(InvalidArgumentException::class);
		$this->expectExceptionMessage('Filesystem object not specified.');

		$this->file->setConfig([
			'file' => 'foobar',
		]);
		$this->file->getContent();
	}

	public function testSetContent()
	{
		$content = 'foobar';
		$file = 'hello.txt';

		$filesystem = \Mockery::mock('League\Flysystem\Filesystem');
		$filesystem->shouldReceive('put')
			->with('hello.txt', $content)
			->once();

		$this->file->setConfig([
			'file' => $file,
			'filesystem' => $filesystem,
		]);

		$this->file->setContent($content);
	}

}
