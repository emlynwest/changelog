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

class ConvertTest extends Unit
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
