<?php
/**
 * PHP Version 5.6
 * @category Library
 * @package ChangeLog
 * @author Emlyn West <emlyn.west@gmail.gom>
 * @license MIT http://opensource.org/licenses/MIT
 * @link https://github.com/emlynwest/changelog
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
			$this->renderRelease($releases, $release);
		}

		$xml = $xml->asXML();
		return ($xml !== false) ? $xml : '' ;
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

	/**
	 * @param SimpleXMLElement $releases
	 * @param Release          $release
	 */
	protected function renderRelease($releases, $release)
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
			$releaseNode->addChild('date',
				$release->getDate()
					->format('Y-m-d')
			);
		}

		$this->addChanges($releaseNode, $release);
	}

}
