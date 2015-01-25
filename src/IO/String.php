<?php
/**
 * PHP Version 5.5
 * @category Library
 * @package ChangeLog
 * @author Steve "uru" West <steve.david.west@gmail.com>
 * @license MIT http://opensource.org/licenses/MIT
 * @link https://github.com/stevewest/changelog
 */

namespace ChangeLog\IO;

use ChangeLog\AbstractIO;

/**
 * Allows a native string to be used as a change log source
 */
class String extends AbstractIO
{

	/**
	 * @var string|string[]
	 */
	protected $content;

	protected $configDefaults = [
		'line_separator' => "\n",
	];

	/**
	 * @param string|string[] $content
	 */
	public function __construct($content = [])
	{
		$this->setContent($content);
	}

	/**
	 * {@inheritdoc}
	 */
	public function setContent($content)
	{
		$this->content = $content;
	}

	/**
	 * {@inheritdoc}
	 */
	public function getContent()
	{
		if (is_string($this->content))
		{
			return explode(
				$this->getConfig('line_separator'),
				$this->content
			);
		}

		return $this->content;
	}
}
