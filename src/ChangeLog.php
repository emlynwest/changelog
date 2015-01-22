<?php
/**
 * PHP Version 5.5
 * @category Library
 * @package ChangeLog
 * @author Steve "uru" West <steve.david.west@gmail.com>
 * @license MIT http://opensource.org/licenses/MIT
 * @link https://github.com/stevewest/changelog
 */

namespace ChangeLog;

use LogicException;

/**
 * Main logic class that ties everything together.
 */
class ChangeLog
{

	/**
	 * @var ParserInterface
	 */
	protected $parser;

	/**
	 * @var IOInterface
	 */
	protected $input;

	/**
	 * @var IOInterface
	 */
	protected $output;

	/**
	 * @param ParserInterface   $parser
	 */
	public function __construct(ParserInterface $parser)
	{
		$this->parser = $parser;
	}

	/**
	 * Reads in the given log and returns the constructed Log object.
	 *
	 * @return Log
	 *
	 * @throws LogicException
	 */
	public function parse()
	{
		if ($this->input === null)
		{
			throw new LogicException('You must specify an IOInterface for input first.');
		}

		return $this->parser->parse(
			$this->input->getContent()
		);
	}

	/**
	 * Writes out the given Log to the chosen output.
	 *
	 * @param Log $log
	 *
	 * @throws LogicException
	 */
	public function write(Log $log)
	{
		if ($this->output === null)
		{
			throw new LogicException('You must specify an IOInterface for output first.');
		}

		$this->output->setContent(
			$this->parser->render($log)
		);
	}

	/**
	 * Sets the adaptor to use for reading change logs.
	 *
	 * @param IOInterface $input
	 */
	public function setInput($input)
	{
		$this->input = $input;
	}

	/**
	 * Sets the adaptor to use for writing change logs.
	 *
	 * @param IOInterface $output
	 */
	public function setOutput($output)
	{
		$this->output = $output;
	}

}
