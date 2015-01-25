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
use Naneau\SemVer\Sort;
use Naneau\SemVer\Version;
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
	 * Adds a release to the Log.
	 * Can be used to replace existing releases too.
	 *
	 * @param Release $release
	 */
	public function addRelease(Release $release)
	{
		$this->releases[$release->getName()] = $release;
		$this->sortReleases();
	}

	/**
	 * Removes a release from the Log.
	 *
	 * @param string $name
	 */
	public function removeRelease($name)
	{
		unset($this->releases[$name]);
	}

	/**
	 * Checks if the Log has the named Release.
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
	}

	/**
	 * Sorts the releases inside this log in accordance with semantic versioning, latest release first.
	 */
	public function sortReleases()
	{
		$order = Sort::sort(array_keys($this->releases));
		$order = array_reverse($order);

		$newOrder = [];
		/** @var Version $version */
		foreach ($order as $version)
		{
			$index = $version->__toString();
			$newOrder[$index] = $this->releases[$index];
		}

		$this->releases = $newOrder;
	}

	/**
	 * Merges another Log's releases with this log.
	 *
	 * @param Log $log
	 */
	public function mergeLog(Log $log)
	{
		/** @var Release $release */
		foreach ($log as $release)
		{
			$name = $release->getName();
			if ($this->hasRelease($name))
			{
				// if it does exist then merge the changes
				$this->mergeRelease($log, $name);
			}
			else
			{
				// If the release does not exist add it
				$this->addRelease($release);
			}
		}
	}

	/**
	 * Combines all changes of the name of the given release from the given log into this log.
	 *
	 * @param Log    $log
	 * @param string $name
	 */
	protected function mergeRelease(Log $log, $name)
	{
		$myRelease = $this->getRelease($name);
		$theirRelease = $log->getRelease($name);

		$changes = $this->mergeChangesArrays(
			$theirRelease->getAllChanges(),
			$myRelease->getAllChanges()
		);
		$myRelease->setAllChanges($changes);
	}

	/**
	 * Merges two sets of changes.
	 *
	 * @param array $left
	 * @param array $right
	 *
	 * @return array
	 */
	protected function mergeChangesArrays($left, $right)
	{
		$return = $left;

		foreach ($right as $type => $changes)
		{
			if (isset($left[$type]))
			{
				$return[$type] = array_merge($right[$type], $left[$type]);
			}
			else
			{
				$return[$type] = $changes;
			}
		}

		return $return;
	}

}
