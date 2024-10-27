<?php
/**
 * @category Library
 * @license MIT http://opensource.org/licenses/MIT
 * @link https://github.com/emlynwest/changelog
 */

namespace ChangeLog\Console;

use ChangeLog\Stub\AbstractCommandStub;
use Codeception\Test\Unit;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\Tester\CommandTester;

class AbstractCommandTest extends Unit
{
	/**
	 * @var CommandTester
	 */
	protected $commandTester;

	protected function setUp(): void
	{
		parent::setUp();

		$application = new Application();
		$application->add(new AbstractCommandStub('abstract_command'));

		$command = $application->find('abstract_command');
		$this->commandTester = new CommandTester($command);
	}

	public function testExecuteWithNoConfig()
	{
		$this->expectException(ConfigNotFoundException::class);

		$this->commandTester->execute([
			'--config' => 'this should not exist',
		]);
	}
}
