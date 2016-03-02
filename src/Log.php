<?php
/**
 * PHP Version 5.6
 * @category Library
 * @package ChangeLog
 * @author Steve "uru" West <steven.david.west@gmail.com>
 * @license MIT http://opensource.org/licenses/MIT
 * @link https://github.com/stevewest/changelog
 */

namespace ChangeLog;

use ArrayIterator;
use Countable;
use IteratorAggregate;
use Naneau\SemVer\Parser;
use Naneau\SemVer\Sort;
use Naneau\SemVer\Version;
use Traversable;

/**
 * Represents a full change log.
 */
class Log implements IteratorAggregate, Countable
{
	const VERSION_MAJOR = 'major';
	const VERSION_MINOR = 'minor';
	const VERSION_PATCH = 'patch';

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
		$key = strtolower($name);
		if ( ! $this->hasRelease($key))
		{
			return null;
		}

		return $this->releases[$key];
	}

	/**
	 * Adds a release to the Log.
	 * Can be used to replace existing releases too.
	 *
	 * @param Release $release
	 */
	public function addRelease(Release $release)
	{
		$name = strtolower($release->getName());
		$this->releases[$name] = $release;
		$this->sortReleases();
	}

	/**
	 * Removes a release from the Log.
	 *
	 * @param string $name
	 */
	public function removeRelease($name)
	{
		$key = strtolower($name);
		unset($this->releases[$key]);
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
		$key = strtolower($name);
		return isset($this->releases[$key]);
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
		// If there is an unreleased release pull that out and sort the rest
		$unreleased = null;
		if (isset($this->releases['unreleased']))
		{
			$unreleased = $this->releases['unreleased'];
			unset($this->releases['unreleased']);
		}

		$order = Sort::sort(array_keys($this->releases));
		$order = array_reverse($order);

		$newOrder = [];
		/** @var Version $version */
		foreach ($order as $version)
		{
			$index = $version->__toString();
			$newOrder[$index] = $this->releases[$index];
		}

		if ($unreleased !== null)
		{
			$newOrder = ['unreleased' => $unreleased] + $newOrder;
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

	/**
	 * @return Release
	 */
	public function getLatestRelease()
	{
		$releases = $this->releases;

		$release = array_shift($releases);

		if (count($this->releases) > 1 && strtolower($release->getName()) === 'unreleased')
		{
			$release = array_shift($releases);
		}

		return $release;
	}

	public function getNextVersion($type)
	{
		if (! in_array($type, [static::VERSION_MAJOR, static::VERSION_MINOR, static::VERSION_PATCH]))
		{
			return $type;
		}

		$latestRelease = $this->getLatestRelease();

		$version = $latestRelease->getName() === 'unreleased' ? '0.0.0' : $latestRelease->getName() ;

		$semver = Parser::parse($version);
		$patch = $semver->getPatch();
		$minor = $semver->getMinor();
		$major = $semver->getMajor();

		switch ($type)
		{
			case Log::VERSION_PATCH:
				$patch++;
				break;
			case Log::VERSION_MINOR:
				$minor++;
				break;
			case Log::VERSION_MAJOR:
				$major++;
				break;
		}

		return "$major.$minor.$patch";
	}

}
