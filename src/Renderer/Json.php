<?php
/**
 * @category Library
 * @license MIT http://opensource.org/licenses/MIT
 * @link https://github.com/emlynwest/changelog
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
			$content['releases'][$name] = $this->renderRelease($release);
		}

		return json_encode($content);
	}

	/**
	 * @param Release $release
	 *
	 * @return array
	 */
	protected function renderRelease(Release $release)
	{
		$date = null;

		if ($release->getDate() !== null)
		{
			$date = $release->getDate()->format('Y-m-d');
		}

		return [
			'name' => $release->getName(),
			'link' => $release->getLink(),
			'linkName' => $release->getLinkName(),
			'date' => $date,
			'changes' => $release->getAllChanges(),
		];
	}

}
