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

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Publishes a new release.
 */
class Release extends BaseCommand
{
	public function getDescription()
	{
		return 'Publishes the unreleased version as a released version.';
	}

	protected function configure()
	{
		$this->addArgument(
			'release',
			InputOption::VALUE_REQUIRED,
			'New release number'
		);
	}

	public function execute(InputInterface $input, OutputInterface $output)
	{
		parent::execute($input, $output);

		$this->output = $output;

		$releaseName = $input->getArgument('release');

		if ($releaseName === null) {
			$output->writeln('<error>A release name is required</error>');
			return;
		}

		// TODO: Don't continue if the release is not found
		// TODO: Don't continue if the release already exists
		$log = $this->changeLog->parse();
		$release = $log->getRelease('Unreleased');
		$release->setName($releaseName);

		$this->changeLog->write($log);
	}
}
