<?php
/**
 * PHP Version 5.5
 * @category Library
 * @package ChangeLog
 * @author Steve "uru" West <steven.david.west@gmail.com>
 * @license MIT http://opensource.org/licenses/MIT
 * @link https://github.com/stevewest/changelog
 */

namespace ChangeLog\Renderer;

use ChangeLog\Log;
use ChangeLog\Release;
use ChangeLog\RenderInterface;
use SimpleXMLElement;

/**
 * Allows change logs to be rendered to XML.
 */
class Xml implements RenderInterface
{

	/**
	 * {@inheritdoc}
	 */
	public function render(Log $log)
	{
		$xml = new SimpleXMLElement('<?xml version="1.0" encoding="UTF-8"?><log />');

		$xml->addChild('title', $log->getTitle());
		$xml->addChild('description', $log->getDescription());

		$releases = $xml->addChild('releases');

		/** @var Release $release */
		foreach ($log as $release)
		{
			$releaseNode = $releases->addChild('release');
			$releaseNode->addChild('name', $release->getName());
			$releaseNode->addChild('link', $release->getLink());

			if ($release->getLinkName() !== null)
			{
				$releaseNode->addChild('linkName', $release->getLinkName());
			}

			if ($release->getDate() !== null)
			{
				$releaseNode->addChild('date', $release->getDate()->format('Y-m-d'));
			}

			$this->addChanges($releaseNode, $release);
		}

		return $xml->asXML();
	}

	/**
	 * Adds the release's changes to the given xml release node.
	 *
	 * @param SimpleXMLElement $releaseNode
	 * @param Release          $release
	 */
	protected function addChanges(SimpleXMLElement $releaseNode, Release $release)
	{
		$changesNode = $releaseNode->addChild('changes');

		foreach ($release->getAllChanges() as $type => $changes)
		{
			$typeNode = $changesNode->addChild('type');
			$typeNode->addAttribute('name', $type);

			foreach ($changes as $change)
			{
				$typeNode->addChild('change', $change);
			}
		}
	}

}
