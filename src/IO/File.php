<?php
/**
 * PHP Version 5.5
 * @category Library
 * @package ChangeLog
 * @author Steve "uru" West <steven.david.west@gmail.com>
 * @license MIT http://opensource.org/licenses/MIT
 * @link https://github.com/stevewest/changelog
 */

namespace ChangeLog\IO;

use ChangeLog\AbstractIO;
use InvalidArgumentException;

/**
 * Allows change logs to be loaded from the file system.
 *
 * Config can contain the keys 'file' and 'line_separator'. 'file' is not optional.
 */
class File extends AbstractIO
{

	protected $configDefaults = [
		'line_separator' => "\n",
	];

	/**
	 * {@inheritdoc}
	 *
	 * @throws InvalidArgumentException
	 */
	public function getContent()
	{
		$file = $this->getFileLocation();

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

	/**
	 * {@inheritdoc}
	 */
	public function setContent($content)
	{
		$file = $this->getFileLocation();
		file_put_contents($file, $content);
	}

	/**
	 * Gets the file location from the config.
	 *
	 * @return string
	 */
	protected function getFileLocation()
	{
		$file = $this->getConfig('file');

		if ( ! $file)
		{
			throw new InvalidArgumentException('File not specified.');
		}

		return $file;
	}

}
