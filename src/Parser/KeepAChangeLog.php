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
			else
			{
				$description[] = $line;
			}

			$line = ltrim(next($content));
		}

		$log->setDescription(implode("\n", $description));
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
				$release->setName($this->trimHashes($line));
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
	 * {@inheritdoc}
	 */
	public function render(Log $log)
	{
		$content = "# {$log->getTitle()}\n" .
			"{$log->getDescription()}\n";

		/** @var Release $release */
		foreach ($log as $release)
		{
			$content .= $this->renderRelease($release);
		}

		// Shave off the last extra \n before returning
		return $content;
	}

	public function renderRelease(Release $release)
	{
		$content = "\n## {$release->getName()}\n";

		foreach ($release->getAllChanges() as $type => $changes)
		{
			$content .= $this->renderType($type, $changes);
		}

		return substr($content, 0, strlen($content)-1);
	}

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

}
