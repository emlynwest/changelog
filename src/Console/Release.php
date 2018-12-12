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

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Publishes a new release.
 */
class Release extends AbstractCommand
{
	/**
	 * @return string
	 * @codeCoverageIgnore
	 */
	public function getDescription()
	{
		return 'Publishes the unreleased version as a released version.';
	}

	protected function configure()
	{
		parent::configure();

		$this->addArgument(
			'release',
			InputOption::VALUE_REQUIRED,
			'New release number, can be any valid semver or [major|minor|patch]'
		);
		$this->addOption(
			'link',
			null,
			InputOption::VALUE_REQUIRED,
			'Optional link to the release\'s info page'
		);
		$this->addOption(
			'linkName',
			null,
			InputOption::VALUE_REQUIRED,
			'Optional link name, release name will be used if not specified'
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

		$newLink = $input->getOption('link');

		if ($newLink === null) {
			$release->setLink(null);
			$release->setLinkName(null);
		} else {
			$newLinkName = $input->getOption('linkName');
			$newLinkName = $newLinkName === null ? $newReleaseName : $newLinkName;

			$release->setLink($newLink);
			$release->setLinkName($newLinkName);
		}

		// Remove and re-add the release to trigger the log internals
		$log->addRelease($release);
		$log->removeRelease('unreleased');

		$this->changeLog->write($log);
	}
}
