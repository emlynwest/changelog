<?php
/**
 * PHP Version 5.5
 * @category Library
 * @package ChangeLog
 * @author Steve "uru" West <uruwolf@gmail.com>
 * @license MIT http://opensource.org/licenses/MIT
 * @link https://github.com/stevewest/changelog
 */

namespace ChangeLog\Provider;

use ChangeLog\AbstractProvider;
use InvalidArgumentException;

/**
 * Allows change logs to be loaded from the file system.
 */
class File extends AbstractProvider
{

	protected $handle;

	/**
	 * Returns the next available line of the change log or null if there is no more
	 * content.
	 *
	 * @return string|null
	 *
	 * @throws InvalidArgumentException
	 */
	public function nextLine()
	{
		// If there's no open file handle then create one
		if ($this->handle === null)
		{
			$file = $this->getConfig('file');

			if ( ! $file || ! is_file($file))
			{
				throw new InvalidArgumentException('File not specified or invalid.');
			}

			$this->handle = fopen($file, 'r');
		}

		// Read the next line
		$line = fgets($this->handle);

		// If false then we are done and just return null
		return ( ! $line) ? null : trim($line);
	}

}
