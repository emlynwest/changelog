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
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Shared common logic for commands.
 */
abstract class AbstractCommand extends Command
{
	const DEFAULT_FACTORY = 'default';

	/**
	 * @var array
	 */
	protected $config;

	/**
	 * @var ChangeLog
	 */
	protected $changeLog;

	protected function configure()
	{
		$this->addOption(
			'config',
			null,
			InputOption::VALUE_OPTIONAL,
			'Location of config file.',
			'changelog.config.php'
		);
		$this->addOption(
			'input',
			null,
			InputOption::VALUE_OPTIONAL,
			'Config to use for input processor',
			'default'
		);
		$this->addOption(
			'parser',
			null,
			InputOption::VALUE_OPTIONAL,
			'Config to use for parser processor',
			'default'
		);
		$this->addOption(
			'renderer',
			null,
			InputOption::VALUE_OPTIONAL,
			'Config to use for renderer processor',
			'default'
		);
		$this->addOption(
			'output',
			null,
			InputOption::VALUE_OPTIONAL,
			'Config to use for output processor',
			'default'
		);
	}

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

		$this->setInput($input->getOption('input'));
		$this->setParser($input->getOption('parser'));
		$this->setRenderer($input->getOption('renderer'));
		$this->setOutput($input->getOption('output'));
	}

	protected function setInput($factoryName)
	{
		$factory = new GenericFactory('\ChangeLog\IO\\');
		$instance = $factory->getInstance(
			$this->config['input'][$factoryName]['strategy'],
			$this->config['input'][$factoryName]['config']
		);
		$this->changeLog->setInput($instance);
	}

	protected function setParser($factoryName)
	{
		$factory = new GenericFactory('\ChangeLog\Parser\\');
		$instance = $factory->getInstance($this->config['parser'][$factoryName]['strategy']);
		$this->changeLog->setParser($instance);
	}

	protected function setRenderer($factoryName)
	{
		$factory = new GenericFactory('\ChangeLog\Renderer\\');
		$instance = $factory->getInstance($this->config['renderer'][$factoryName]['strategy']);
		$this->changeLog->setRenderer($instance);
	}

	protected function setOutput($factoryName)
	{
		$factory = new GenericFactory('\ChangeLog\IO\\');
		$instance = $factory->getInstance(
			$this->config['output'][$factoryName]['strategy'],
			$this->config['output'][$factoryName]['config']
		);
		$this->changeLog->setOutput($instance);
	}

}
