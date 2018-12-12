<?php
/**
 * PHP Version 5.6
 * @category Library
 * @package ChangeLog
 * @author Emlyn West <emlyn.west@gmail.gom>
 * @license MIT http://opensource.org/licenses/MIT
 * @link https://github.com/emlynwest/changelog
 */

namespace ChangeLog\Console;

use Codeception\TestCase\Test;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\Tester\CommandTester;

class ConvertTest extends Test
{
	public function testConvert()
	{
		$outputPath = __DIR__ . '/../../_output/changelog.json';
		@unlink($outputPath);

		$application = new Application();
		$application->add(new Convert('convert'));

		$command = $application->find('convert');
		$commandTester = new CommandTester($command);
		$commandTester->execute(['--config' => __DIR__.'/../../resources/changelog.config.php']);

		$this->assertFileExists($outputPath);
	}
}
