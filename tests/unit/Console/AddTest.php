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

class AddTest extends Test
{
	/**
	 * @var CommandTester
	 */
	protected $commandTester;

	protected function setUp()
	{
		parent::setUp();

		$application = new Application();
		$application->add(new Add('add'));

		$command = $application->find('add');
		$this->commandTester = new CommandTester($command);
	}

	public function testAddToExistingRelease()
	{
		$outputPath = __DIR__ . '/../../_output/changelog.json';
		@unlink($outputPath);

		$this->commandTester->execute([
			'release' => '0.0.6',
			'type' => 'foobar',
			'change' => 'something',
			'--config' => __DIR__.'/../../resources/changelog.config.php',
		]);

		$this->assertFileExists($outputPath);
		$jsonContent = json_decode(file_get_contents($outputPath), true);

		$this->assertFalse(empty($jsonContent['releases']['0.0.6']['changes']['foobar']));
		$this->assertTrue(in_array('something', $jsonContent['releases']['0.0.6']['changes']['foobar']));
	}

	public function testAddToNewRelease()
	{
		$outputPath = __DIR__ . '/../../_output/changelog.json';
		@unlink($outputPath);

		$this->commandTester->execute([
			'release' => '1.0.0',
			'type' => 'flip-flopped',
			'change' => 'something',
			'--config' => __DIR__.'/../../resources/changelog.config.php',
		]);

		$this->assertFileExists($outputPath);
		$jsonContent = json_decode(file_get_contents($outputPath), true);

		$this->assertFalse(empty($jsonContent['releases']['1.0.0']['changes']['flip-flopped']));
		$this->assertTrue(in_array('something', $jsonContent['releases']['1.0.0']['changes']['flip-flopped']));
	}
}
