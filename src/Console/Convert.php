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
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Converts a release between formats.
 */
class Convert extends AbstractCommand
{
	/**
	 * @return string
	 */
	public function getDescription()
	{
		return "Converts a release between formats.\n\n" .
			"\tUses the global input, parser, renderer and output flags for processing.";
	}

	public function execute(InputInterface $input, OutputInterface $output)
	{
		parent::execute($input, $output);

		$log = $this->changeLog->parse();
		$this->changeLog->write($log);
	}

}
