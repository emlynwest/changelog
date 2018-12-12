<?php
/**
 * PHP Version 5.6
 *
 * @category Library
 *
 * @author Emlyn West <emlyn.west@gmail.gom>
 * @license MIT http://opensource.org/licenses/MIT
 *
 * @see https://github.com/emlynwest/changelog
 */

namespace ChangeLog\Console;

use Codeception\TestCase\Test;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\Tester\CommandTester;

class MergeTest extends Test
{
	/**
	 * @var CommandTester
	 */
	protected $commandTester;

	protected function setUp()
	{
		parent::setUp();

		$application = new Application();
		$application->add(new Merge('merge'));

		$command = $application->find('merge');
		$this->commandTester = new CommandTester($command);
	}

	public function testMergeMultipleChangelog()
	{
		$outputPath = __DIR__.'/../../_output/changelog.json';
		@unlink($outputPath);

		$this->commandTester->execute([
			'files' => [
				__DIR__.'/../../resources/partial-changelog-1.md',
				__DIR__.'/../../resources/partial-changelog-2.md',
			],
			'--config' => __DIR__.'/../../resources/changelog.config.merge.php',
		]);

		$this->assertFileExists($outputPath);
		$jsonContent = json_decode(file_get_contents($outputPath), true);

		$this->assertCount(2, $jsonContent['releases']['unreleased']['changes']['Fixed']);
	}
}
