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

use ArrayIterator;
use Countable;
use IteratorAggregate;
use Traversable;

/**
 * Represents a full change log.
 */
class Log implements IteratorAggregate, Countable
{

	/**
	 * @var string
	 */
	protected $description = '';

	/**
	 * @var Release[]
	 */
	protected $releases = [];

	/**
	 * @var string
	 */
	protected $title = '';

	/**
	 * Gets all the releases for the log.
	 *
	 * @return Release[]
	 */
	public function getReleases()
	{
		return $this->releases;
	}

	/**
	 * Gets the named release.
	 *
	 * @param string $name
	 *
	 * @return Release|null
	 */
	public function getRelease($name)
	{
		if ( ! $this->hasRelease($name))
		{
			return null;
		}

		return $this->releases[$name];
	}

	/**
	 * Adds a release to the log.
	 * Can be used to replace existing releases too.
	 *
	 * @param Release $release
	 */
	public function addRelease(Release $release)
	{
		$this->releases[$release->getName()] = $release;
	}

	/**
	 * Checks if the log has the named release.
	 *
	 * @param string $name
	 *
	 * @return bool
	 */
	public function hasRelease($name)
	{
		return isset($this->releases[$name]);
	}

	/**
	 * @return string
	 */
	public function getDescription()
	{
		return $this->description;
	}

	/**
	 * @param string $description
	 */
	public function setDescription($description)
	{
		$this->description = $description;
	}

	/**
	 * @return string
	 */
	public function getTitle()
	{
		return $this->title;
	}

	/**
	 * @param string $title
	 */
	public function setTitle($title)
	{
		$this->title = $title;
	}

	/**
	 * {@inheritdoc}
	 */
	public function getIterator()
	{
		return new ArrayIterator($this->releases);
	}

	/**
	 * {@inheritdoc}
	 */
	public function count()
	{
		return count($this->releases);
	}}
