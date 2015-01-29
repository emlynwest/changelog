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

/**
 * Allows change logs to be rendered to json
 */
class Json implements RenderInterface
{

	/**
	 * {@inheritdoc}
	 */
	public function render(Log $log)
	{
		$content = [
			'title' => $log->getTitle(),
			'description' => $log->getDescription(),
			'releases' => [],
		];

		/**
		 * @var string  $name
		 * @var Release $release
		 */
		foreach ($log as $name => $release)
		{
			$date = null;

			if ($release->getDate() !== null)
			{
				$date = $release->getDate()->format('Y-m-d');
			}

			$content['releases'][$name] = [
				'name' => $release->getName(),
				'link' => $release->getLink(),
				'linkName' => $release->getLinkName(),
				'date' => $date,
				'changes' => $release->getAllChanges(),
			];
		}

		return json_encode($content);
	}

}
