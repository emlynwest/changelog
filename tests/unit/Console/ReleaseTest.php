<?php
/**
 * PHP Version 5.6
 * @category Library
 * @package ChangeLog
 * @author Steve "uru" West <steven.david.west@gmail.com>
 * @license MIT http://opensource.org/licenses/MIT
 * @link https://github.com/stevewest/changelog
 */

namespace ChangeLog\Console;

use Codeception\TestCase\Test;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\Tester\CommandTester;

class ReleaseTest extends Test
{
	/**
	 * @var CommandTester
	 */
	protected $commandTester;

	protected function setUp()
	{
		parent::setUp();

		$application = new Application();
		$application->add(new Release('release'));

		$command = $application->find('release');
		$this->commandTester = new CommandTester($command);
	}

	/**
	 * @expectedException \ChangeLog\Console\InvalidArgumentException
	 */
	public function testMissingRelease()
	{
		$this->commandTester->execute([
			'--config' => __DIR__.'/../../resources/changelog.config.php',
		]);
	}

	/**
	 * @expectedException \ChangeLog\Console\ReleaseNotFoundException
	 */
	public function testNoUnreleased()
	{
		$this->commandTester->execute([
			'release' => 'foobar',
			'--config' => __DIR__.'/../../resources/changelog.config_missing_unlreleased.php',
		]);
	}

	/**
	 * @expectedException \ChangeLog\Console\ReleaseExistsException
	 */
	public function testExistingRelease()
	{
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

		$this->assertArraySubset(
			[
				'releases' => [
					'1.0.0' => [
						'name' => '1.0.0',
					],
				],
			],
			$jsonContent
		);
	}
}
