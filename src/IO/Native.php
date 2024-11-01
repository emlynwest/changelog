<?php
/**
 * @category Library
 * @license MIT http://opensource.org/licenses/MIT
 * @link https://github.com/emlynwest/changelog
 */

namespace ChangeLog\IO;

use ChangeLog\AbstractIO;

/**
 * Allows a native string to be used as a change log source
 */
class Native extends AbstractIO
{

	/**
	 * @var string|string[]
	 */
	protected $content;

	protected $configDefaults = [
		'line_separator' => "\n",
	];

	/**
	 * @param string $content
	 */
	public function __construct($content = '')
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
