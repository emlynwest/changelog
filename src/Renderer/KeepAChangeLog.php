<?php
/**
 * PHP Version 5.5
 * @category Library
 * @package ChangeLog
 * @author Steve "uru" West <steve.david.west@gmail.com>
 * @license MIT http://opensource.org/licenses/MIT
 * @link https://github.com/stevewest/changelog
 */

namespace ChangeLog\Renderer;

use ChangeLog\Log;
use ChangeLog\Release;
use ChangeLog\RenderInterface;

/**
 * Allows change logs to be rendered into the http://keepachangelog.com format.
 */
class KeepAChangeLog implements RenderInterface
{

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
