<?php
/**
 * @category Library
 * @license MIT http://opensource.org/licenses/MIT
 * @link https://github.com/emlynwest/changelog
 */

namespace ChangeLog\Console;

use Codeception\Test\Unit;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\Tester\CommandTester;

class ReleaseTest extends Unit
{
	/**
	 * @var CommandTester
	 */
	protected $commandTester;

	protected function setUp(): void
	{
		parent::setUp();

		$application = new Application();
		$application->add(new Release('release'));

		$command = $application->find('release');
		$this->commandTester = new CommandTester($command);
	}

	public function testMissingRelease()
	{
		$this->expectException(InvalidArgumentException::class);

		$this->commandTester->execute([
			'--config' => __DIR__.'/../../resources/changelog.config.php',
		]);
	}

	public function testNoUnreleased()
	{
		$this->expectException(ReleaseNotFoundException::class);

		$this->commandTester->execute([
			'release' => 'foobar',
			'--config' => __DIR__.'/../../resources/changelog.config_missing_unlreleased.php',
		]);
	}

	public function testExistingRelease()
	{
		$this->expectException(ReleaseExistsException::class);

		$this->commandTester->execute([
			'release' => '0.0.6',
			'--config' => __DIR__.'/../../resources/changelog.config.php',
		]);
	}

	public function testRelease()
	{
		$outputPath = __DIR__ . '/../../_output/changelog.json';
		@unlink($outputPath);

		$this->commandTester->execute([
			'release' => '1.0.0',
			'--config' => __DIR__.'/../../resources/changelog.config.php',
		]);

		$this->assertFileExists($outputPath);
		$jsonContent = json_decode(file_get_contents($outputPath), true);

		$this->assertEquals('1.0.0', $jsonContent['releases']['1.0.0']['name']);
		$this->assertEquals(null, $jsonContent['releases']['1.0.0']['link']);
		$this->assertEquals(null, $jsonContent['releases']['1.0.0']['linkName']);
	}

	public function testReleaseWithLink()
	{
		$outputPath = __DIR__ . '/../../_output/changelog.json';
		@unlink($outputPath);

		$this->commandTester->execute([
			'release' => '1.0.0',
			'--link' => 'http://foobar.com/release/1.0.0',
			'--config' => __DIR__.'/../../resources/changelog.config.php',
		]);

		$this->assertFileExists($outputPath);
		$jsonContent = json_decode(file_get_contents($outputPath), true);

		$this->assertEquals('1.0.0', $jsonContent['releases']['1.0.0']['name']);
		$this->assertEquals('http://foobar.com/release/1.0.0', $jsonContent['releases']['1.0.0']['link']);
		$this->assertEquals('1.0.0', $jsonContent['releases']['1.0.0']['linkName']);
	}

	public function testReleaseWithName()
	{
		$outputPath = __DIR__ . '/../../_output/changelog.json';
		@unlink($outputPath);

		$this->commandTester->execute([
			'release' => '1.0.0',
			'--link' => 'http://foobar.com/release/1.0.0',
			'--linkName' => 'hello',
			'--config' => __DIR__.'/../../resources/changelog.config.php',
		]);

		$this->assertFileExists($outputPath);
		$jsonContent = json_decode(file_get_contents($outputPath), true);

		$this->assertEquals('1.0.0', $jsonContent['releases']['1.0.0']['name']);
		$this->assertEquals('http://foobar.com/release/1.0.0', $jsonContent['releases']['1.0.0']['link']);
		$this->assertEquals('hello', $jsonContent['releases']['1.0.0']['linkName']);
	}
}
