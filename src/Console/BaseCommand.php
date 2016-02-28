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

use ChangeLog\ChangeLog;
use ChangeLog\GenericFactory;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Shared common logic for commands.
 */
class BaseCommand extends Command
{
	/**
	 * @var array
	 */
	protected $config;

	/**
	 * @var ChangeLog
	 */
	protected $changeLog;

	public function execute(InputInterface $input, OutputInterface $output)
	{
		$configLocation = $input->getOption('config');

		if ( ! is_file($configLocation) && ! is_readable($configLocation))
		{
			throw new ConfigNotFoundException('Unable to open config file: ' . $configLocation);
		}

		$this->config = require $configLocation;

		// Construct a changelog object to manipulate
		$this->changeLog = new ChangeLog();

		$this->setInput();
		$this->setParser();
		$this->setRenderer();
		$this->setOutput();
	}

	protected function setInput()
	{
		$factory = new GenericFactory('\ChangeLog\IO\\');
		$instance = $factory->getInstance($this->config['input']['strategy'], $this->config['input']['config']);
		$this->changeLog->setInput($instance);
	}

	protected function setParser()
	{
		$factory = new GenericFactory('\ChangeLog\Parser\\');
		$instance = $factory->getInstance($this->config['parser']['strategy']);
		$this->changeLog->setParser($instance);
	}

	protected function setRenderer()
	{
		$factory = new GenericFactory('\ChangeLog\Renderer\\');
		$instance = $factory->getInstance($this->config['renderer']['strategy']);
		$this->changeLog->setRenderer($instance);
	}

	protected function setOutput()
	{
		$factory = new GenericFactory('\ChangeLog\IO\\');
		$instance = $factory->getInstance($this->config['output']['strategy'], $this->config['output']['config']);
		$this->changeLog->setOutput($instance);
	}

}
