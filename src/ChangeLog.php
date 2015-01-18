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

/**
 * Class ChangeLog
 */
class ChangeLog
{

	/**
	 * @var ParserInterface
	 */
	protected $parser;

	/**
	 * @var ProviderInterface
	 */
	protected $provider;

	/**
	 * @param ProviderInterface $provider
	 * @param ParserInterface   $parser
	 */
	public function __construct(ProviderInterface $provider, ParserInterface $parser)
	{
		$this->provider = $provider;
		$this->parser = $parser;
	}

	/**
	 * @return Log
	 */
	public function parse()
	{
		return $this->parser->parse(
			$this->provider->getContent()
		);
	}

}
