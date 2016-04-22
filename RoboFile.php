<?php
/**
 * PHP Version 5.6
 * @category Library
 * @package  ChangeLog
 * @author   Steve "uru" West <steven.david.west@gmail.com>
 * @license  MIT http://opensource.org/licenses/MIT
 * @link     https://github.com/stevewest/changelog
 */

use Robo\Tasks;
use Symfony\Component\Finder\Finder;

class RoboFile extends Tasks
{
	public function createPhar()
	{
		$collection = $this->collection();

		$this->taskComposerInstall()
			->noDev()
			->optimizeAutoloader()
			->printed(false)
			->addToCollection($collection);

		$packer = $this->taskPackPhar('package/changelog.phar')
			->compress(true)
			->stub('package/stub.php');

		$files = Finder::create()
			->ignoreVCS(true)
			->files()
			->name('*.php')
			->path('src')
			->path('vendor')
			->in(__DIR__);

		foreach ($files as $file) {
			$packer->addFile($file->getRelativePathname(), $file->getRealPath());
		}

		@unlink('package/bin');
		@unlink('package/changelog.phar');
		copy('changelog', 'package/bin');

		$packer->addFile('changelog', 'package/bin')
			->addToCollection($collection);

		$this->taskComposerInstall()
			 ->printed(false)
			 ->addToCollection($collection);

		$collection->run();
	}
}
