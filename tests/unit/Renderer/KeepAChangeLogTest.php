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
use Codeception\TestCase\Test;
use DateTime;

/**
 * Tests for KeepAChangeLog
 */
class KeepAChangeLogTest extends Test
{

	/**
	 * @var KeepAChangeLog
	 */
	protected $renderer;

	protected function _before()
	{
		$this->renderer = new KeepAChangeLog;
	}

	public function testRender()
	{
		$log = new Log;
		$log->setDescription('This is my change log, it will have lots of changes in it!');
		$log->setTitle('My change log');

		$release1 = new Release('1.0.0');
		$release1->setAllChanges([
			'Added' => ['Thing 1', 'Thing 2'],
			'Changed' => ['Some change']
		]);
		$log->addRelease($release1);

		$release2 = new Release('0.1.0');
		$release2->setAllChanges([
			'Added' => ['Initial release'],
		]);
		$log->addRelease($release2);

		$expected = <<<'CONTENT'
# My change log
This is my change log, it will have lots of changes in it!

## 1.0.0
### Added
- Thing 1
- Thing 2

### Changed
- Some change

## 0.1.0
### Added
- Initial release

CONTENT;

		$actual = $this->renderer->render($log);
		$this->assertEquals(
			$expected,
			$actual
		);

	}

	public function testDateRender()
	{
		$release = new Release('1.0.0');
		$release->setDate(DateTime::createFromFormat('Y-m-d', '2015-01-25'));

		$result = $this->renderer->renderRelease($release);
		$this->assertEquals(
			"\n## 1.0.0 - 2015-01-25",
			$result
		);
	}

	public function testYankedRender()
	{
		$release = new Release('1.0.0');
		$release->setYanked(true);

		$result = $this->renderer->renderRelease($release);
		$this->assertEquals(
			"\n## 1.0.0 [YANKED]",
			$result
		);
	}

	public function testRenderLink()
	{
		$log = new Log();
		$log->setTitle('Change log');
		$log->setDescription('My change log');

		$release1 = new Release('1.0.0');
		$release1->setLink('http://fuelphp.com');
		$log->addRelease($release1);

		$expected = <<<'EXPECTED'
# Change log
My change log

## [1.0.0]

[1.0.0] http://fuelphp.com

EXPECTED;

		$result = $this->renderer->render($log);

		$this->assertEquals(
			$expected,
			$result
		);
	}

}
