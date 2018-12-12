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

use ChangeLog\Release as LogRelease;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Converts a release between formats.
 */
class Add extends AbstractCommand
{
	/**
	 * @return string
	 * @codeCoverageIgnore
	 */
	public function getDescription()
	{
		return 'Adds a change to a release.';
	}

	protected function configure()
	{
		parent::configure();

		$this->addArgument(
			'release',
			InputOption::VALUE_REQUIRED,
			'Release to add the change to, will be created if it does not exist.'
		);

		$this->addArgument(
			'type',
			InputOption::VALUE_REQUIRED,
			'Added, fixed, changed, etc'
		);

		$this->addArgument(
			'change',
			InputOption::VALUE_REQUIRED,
			'Change message, eg "fixed issue #123"'
		);
	}

	public function execute(InputInterface $input, OutputInterface $output)
	{
		parent::execute($input, $output);

		$log = $this->changeLog->parse();

		$releaseName = $input->getArgument('release');

		// Create the release_name if needed
		if ( ! $log->hasRelease($releaseName)) {
			$newRelease = new LogRelease($releaseName);
			$log->addRelease($newRelease);
		}

		$release = $log->getRelease($releaseName);

		$release->addChange($input->getArgument('type'), $input->getArgument('change'));

		$this->changeLog->write($log);
	}

}
