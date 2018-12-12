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

use ChangeLog\Stub\AbstractCommandStub;
use Codeception\TestCase\Test;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\Tester\CommandTester;

class AbstractCommandTest extends Test
{
	/**
	 * @var CommandTester
	 */
	protected $commandTester;

	protected function setUp()
	{
		parent::setUp();

		$application = new Application();
		$application->add(new AbstractCommandStub('abstract_command'));

		$command = $application->find('abstract_command');
		$this->commandTester = new CommandTester($command);
	}

	/**
	 * @expectedException \ChangeLog\Console\ConfigNotFoundException
	 */
	public function testExecuteWithNoConfig()
	{
		$this->commandTester->execute([
			'--config' => 'this should not exist',
		]);
	}
}
