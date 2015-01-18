<?php
/**
 * PHP Version 5.5
 * @category Library
 * @package ChangeLog
 * @author Steve "uru" West <steve.david.west@gmail.com>
 * @license MIT http://opensource.org/licenses/MIT
 * @link https://github.com/stevewest/changelog
 */

namespace ChangeLog\Provider;

use ChangeLog\AbstractProvider;
use InvalidArgumentException;

/**
 * Allows change logs to be loaded from the file system.
 *
 * Config can contain the keys 'file' and 'line_separator'. 'file' is not optional.
 */
class File extends AbstractProvider
{

	protected $configDefaults = [
		'line_separator' => "\n",
	];

	protected $handle;

	/**
	 * {@inheritdoc}
	 *
	 * @throws InvalidArgumentException
	 */
	public function getContent()
	{
		$file = $this->getConfig('file');

		if ( ! $file || ! is_file($file))
		{
			throw new InvalidArgumentException('File not specified or invalid.');
		}

		$content = file_get_contents($file);

		if ( ! $content)
		{
			return null;
		}

		return explode(
			$this->getConfig('line_separator'),
			$content
		);
	}

}
