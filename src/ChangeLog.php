<?php
/**
 * PHP Version 5.6
 * @category Library
 * @package ChangeLog
 * @author Emlyn West <emlyn.west@gmail.gom>
 * @license MIT http://opensource.org/licenses/MIT
 * @link https://github.com/emlynwest/changelog
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
	 * @var RenderInterface
	 */
	protected $renderer;

	/**
	 * @var IOInterface
	 */
	protected $input;

	/**
	 * @var IOInterface
	 */
	protected $output;

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
			$this->renderer->render($log)
		);
	}

	/**
	 * Sets the adaptor to use for reading change logs.
	 *
	 * @param IOInterface $input
	 */
	public function setInput(IOInterface $input)
	{
		$this->input = $input;
	}

	/**
	 * Sets the adaptor to use for writing change logs.
	 *
	 * @param IOInterface $output
	 */
	public function setOutput(IOInterface $output)
	{
		$this->output = $output;
	}

	/**
	 * Sets the adaptor to render with.
	 *
	 * @param RenderInterface $renderer
	 */
	public function setRenderer(RenderInterface $renderer)
	{
		$this->renderer = $renderer;
	}

	/**
	 * Sets the adaptor to parse with.
	 *
	 * @param ParserInterface $parser
	 */
	public function setParser(ParserInterface $parser)
	{
		$this->parser = $parser;
	}

}
