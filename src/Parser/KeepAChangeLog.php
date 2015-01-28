<?php
/**
 * PHP Version 5.5
 * @category Library
 * @package ChangeLog
 * @author Steve "uru" West <steve.david.west@gmail.com>
 * @license MIT http://opensource.org/licenses/MIT
 * @link https://github.com/stevewest/changelog
 */

namespace ChangeLog\Parser;

use ChangeLog\Log;
use ChangeLog\ParserInterface;
use ChangeLog\Release;
use DateTime;

/**
 * Allows change logs to be parsed from the http://keepachangelog.com format.
 */
class KeepAChangeLog implements ParserInterface
{

	/**
	 * Takes the given content and parses it into a populated Log object.
	 *
	 * @param string[] $content
	 *
	 * @return Log
	 */
	public function parse($content)
	{
		$log = new Log;
		$description = [];
		$links = [];
		$matches = [];

		$line = ltrim(current($content));
		while ($line)
		{
			if (preg_match('/^#(?!#).+/', $line) === 1)
			{
				$log->setTitle($this->trimHashes($line));
			}
			else if(preg_match('/^##(?!#).+/', $line) === 1)
			{
				$release = $this->parseRelease($content);
				$log->addRelease($release);
			}
			else if(preg_match('/\[(.+)\] (.+)/', $line, $matches))
			{
				if (count($matches) >= 3)
				{
					$links[$matches[1]] = $matches[2];
				}
			}
			else
			{
				$description[] = $line;
			}

			$line = ltrim(next($content));
		}

		$log->setDescription(implode("\n", $description));

		// Assign the releases their real links
		/** @var Release $release */
		foreach ($log as $release)
		{
			$link = null;
			$linkName = $release->getLink();
			if (isset($links[$linkName]))
			{
				$link = $links[$linkName];
			}
			$release->setLink($link);
		}

		return $log;
	}

	/**
	 * Trims off whitespace and excess hashes from the start of a string.
	 *
	 * @param string $line
	 *
	 * @return string
	 */
	public function trimHashes($line)
	{
		return ltrim($line, "\t\n\r\0\x0B# ");
	}

	/**
	 * Returns true if $haystack starts with $needle.
	 *
	 * @param $haystack
	 * @param $needle
	 *
	 * @return bool
	 */
	public function startsWith($haystack, $needle)
	{
		return (substr($haystack, 0, strlen($needle)) === $needle);
	}

	/**
	 * Builds a release.
	 *
	 * @param string[] $content
	 *
	 * @return Release
	 */
	public function parseRelease(&$content)
	{
		$release = new Release;
		$types = [];
		$lastType = '';
		$nameSet = false;

		$line = ltrim(current($content));
		while ($line)
		{
			if ($this->startsWith($line, '###'))
			{
				$type = $this->trimHashes($line);
				$types[$type] = [];
				$lastType = $type;
			}
			else if ($nameSet && $this->startsWith($line, '##'))
			{
				prev($content);
				break;
			}
			else if ($this->startsWith($line, '##'))
			{
				$this->handleName($release, $line);
				$nameSet = true;
			}
			else
			{
				$types[$lastType][] = ltrim($line, "\t\n\r\0\x0B -");
			}

			$line = ltrim(next($content));
		}

		$release->setAllChanges($types);
		return $release;
	}

	/**
	 * Pulls out the needed information from a Release title and assigns that to the
	 * given release.
	 *
	 * @param Release $release
	 * @param string  $line
	 */
	protected function handleName(Release $release, $line)
	{
		$this->setName($release, $line);
		$this->setDate($release, $line);
		$this->setLink($release, $line);
		$this->setYanked($release, $line);
	}

	/**
	 * Extracts and sets the name of the link if there is one.
	 *
	 * @param Release $release
	 * @param string  $line
	 */
	protected function setLink(Release $release, $line)
	{
		$matches = [];

		if (preg_match('/^## \[([\w\.-\.]+)\](?:\[(\w+)\])?/', $line, $matches))
		{
			if (count($matches) >= 3)
			{
				$release->setLink($matches[2]);
			}
			else
			{
				$release->setLink($matches[1]);
			}
		}
	}

	/**
	 * Extracts and sets the yanked flag.
	 *
	 * @param Release $release
	 * @param string  $line
	 */
	protected function setYanked(Release $release, $line)
	{
		if (preg_match('/\[YANKED\]$/i', $line))
		{
			$release->setYanked(true);
		}
	}

	/**
	 * Extracts and sets the release Date.
	 *
	 * @param Release $release
	 * @param string  $line
	 */
	protected function setDate(Release $release, $line)
	{
		$matches = [];
		if (preg_match('/[0-9]{4,}-[0-9]{2,}-[0-9]{2,}/', $line, $matches))
		{
			$date = DateTime::createFromFormat('Y-m-d', $matches[0]);
			if ($date)
			{
				$release->setDate($date);
			}
		}
	}

	/**
	 * Extracts and sets the Release name.
	 *
	 * @param Release $release
	 * @param string  $line
	 */
	protected function setName(Release $release, $line)
	{
		$matches = [];
		if (preg_match('/([\w\.-]{1,})/', $line, $matches))
		{
			$release->setName($matches[0]);
		}
	}

	/**
	 * {@inheritdoc}
	 */
	public function render(Log $log)
	{
		$content = "# {$log->getTitle()}\n" .
			"{$log->getDescription()}\n";

		$links = '';

		/** @var Release $release */
		foreach ($log as $release)
		{
			$content .= $this->renderRelease($release);

			$link = $release->getLink();
			if ($link !== null)
			{
				$links .= "[{$release->getName()}] $link\n";
			}
		}

		if ($links !== '')
		{
			$content .= "\n\n" . $links;
		}

		return $content;
	}

	/**
	 * Converts a Release into its text representation.
	 *
	 * @param Release $release
	 *
	 * @return string
	 */
	public function renderRelease(Release $release)
	{
		$name = $release->getName();

		if ($release->getLink() !== null)
		{
			$name = "[$name]";
		}

		$content = "\n## $name";

		$content .= $this->addDate($release);
		$content .= $this->addYanked($release);

		$content .= "\n";

		foreach ($release->getAllChanges() as $type => $changes)
		{
			$content .= $this->renderType($type, $changes);
		}

		return substr($content, 0, strlen($content)-1);
	}

	/**
	 * Converts a list of changes with a given type back into text.
	 *
	 * @param string $type
	 * @param array  $changes
	 *
	 * @return string
	 */
	public function renderType($type, $changes)
	{
		$content = '';

		if (count($changes) > 0)
		{
			$content = "### $type\n" .
				'- ' . implode("\n- ", $changes) . "\n";
		}

		return $content . "\n";
	}

	/**
	 * Adds the date to a Release title for rendering if the Release has a date.
	 *
	 * @param Release $release
	 *
	 * @return string
	 */
	protected function addDate(Release $release)
	{
		$content = '';
		$date = $release->getDate();
		if ($date !== null)
		{
			$content = ' - ' . $date->format('Y-m-d');
		}
		return $content;
	}
	/**
	 * Returns the YANKED tag if needed
	 *
	 * @param Release $release
	 *
	 * @return string
	 */
	protected function addYanked(Release $release)
	{
		$content = '';
		if ($release->isYanked())
		{
			$content = ' [YANKED]';
		}
		return $content;
	}

}
