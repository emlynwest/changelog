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
class Publish extends BaseCommand
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
			'New release number, can be any valid semver or [major|minor|patch]'
		);
	}

	public function execute(InputInterface $input, OutputInterface $output)
	{
		parent::execute($input, $output);

		$releaseName = $input->getArgument('release');

		if ($releaseName === null) {
			throw new InvalidArgumentException('A release name is required');
		}

		$log = $this->changeLog->parse();

		// Don't continue if there is no unreleased version
		if ( ! $log->hasRelease('unreleased')) {
			throw new ReleaseNotFoundException('Unable to find an unreleased version.');
		}

		// Work out what version number we actually want
		$newReleaseName = $log->getNextVersion($releaseName);

		// Don't continue if the release already exists
		if ($log->hasRelease($newReleaseName)) {
			throw new ReleaseExistsException('A release with the name "' . $newReleaseName . '" already exists."');
		}

		$release = $log->getRelease('unreleased');
		$release->setName($newReleaseName);

		$this->changeLog->write($log);
	}
}
