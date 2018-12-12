<?php
/**
 * PHP Version 5.6
 * @category Library
 * @package ChangeLog
 * @author Erwan Richard <erwan.richard@protonmail.com>
 * @license MIT http://opensource.org/licenses/MIT
 * @link https://github.com/emlynwest/changelog
 */

namespace ChangeLog\Console;

use ChangeLog\ChangeLog;
use ChangeLog\IO\File;
use ChangeLog\Parser\KeepAChangeLog;
use ChangeLog\Release as LogRelease;
use ChangeLog\Renderer\KeepAChangeLog as KeepAChangeLogRenderer;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Converts a release between formats.
 */
class Merge extends AbstractCommand
{
	/**
	 * @return string
	 * @codeCoverageIgnore
	 */
	public function getDescription()
	{
		return 'Merge two or more changelog into one.';
	}

	protected function configure()
	{
		parent::configure();

		$this->addArgument(
			'files',
			InputArgument::IS_ARRAY,
			'Changelog to merge.'
		);
	}

	public function execute(InputInterface $input, OutputInterface $output)
	{
		parent::execute($input, $output);

		// Parse existing CHANGELOG
		$logs = $this->changeLog->parse();

		$files = $input->getArgument('files');
		foreach ($files as $f) {
			// Merge each file
			$this->changeLog->setInput(new File(['file' => $f]));
			$logs->mergeLog($this->changeLog->parse());
		}

		// Write updated CHANGELOG
		$this->changeLog->write($logs);
	}
}
