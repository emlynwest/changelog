<?php
/**
 * PHP Version 5.6
 * @category Library
 * @package ChangeLog
 * @author Emlyn West <emlyn.west@gmail.gom>
 * @license MIT http://opensource.org/licenses/MIT
 * @link https://github.com/emlynwest/changelog
 */

namespace ChangeLog\IO;

use ChangeLog\AbstractIO;
use InvalidArgumentException;
use League\Flysystem\Filesystem;

/**
 * Allows change logs to be loaded via a Flysystem adaptor.
 *
 * Config can contain the keys 'file', 'filesystem' and 'line_separator'. 'file' and 'filesystem' are not optional.
 */
class Flysystem extends AbstractIO
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
		$filesystem = $this->getFilesystem();

		$content = $filesystem->read($file);

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
		$filesystem = $this->getFilesystem();

		$filesystem->put($file, $content);
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

	/**
	 * @return Filesystem
	 */
	protected function getFilesystem()
	{
		$adaptor = $this->getConfig('filesystem');

		if ( ! $adaptor)
		{
			throw new InvalidArgumentException('Filesystem object not specified.');
		}

		return $adaptor;
	}

}
