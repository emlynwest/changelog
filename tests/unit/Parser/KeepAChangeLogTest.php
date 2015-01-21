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
use ChangeLog\Release;
use Codeception\TestCase\Test;

/**
 * Tests for KeepAChangeLog
 */
class KeepAChangeLogTest extends Test
{

	/**
	 * @var KeepAChangeLog
	 */
	protected $parser;

	protected function _before()
	{
		$this->parser = new KeepAChangeLog;
	}

	public function testBuildLog()
	{
		$desc1 = 'This is my description.';
		$desc2 = 'It has multiple lines.';
		$content = [
			'# Change log',
			$desc1,
			$desc2,
		];

		$log = $this->parser->parse($content);

		$this->assertInstanceOf(
			'ChangeLog\Log',
			$log
		);

		$this->assertEquals(
			'Change log',
			$log->getTitle()
		);

		$this->assertEquals(
			$desc1."\n".$desc2,
			$log->getDescription()
		);
	}

	public function testBuildRelease()
	{
		$content = [
			'## 1.0.0',
			'### Fixes',
			' - 1',
			'- 2',
			'-3',
			'### Added',
			'-    a',
		];

		$release = $this->parser->parseRelease($content);

		$this->assertInstanceOf(
			'ChangeLog\Release',
			$release
		);

		$this->assertEquals(
			'1.0.0',
			$release->getName()
		);

		$changes = $release->getAllChanges();

		$this->assertArrayHasKey(
			'Fixes',
			$changes
		);

		$this->assertArrayHasKey(
			'Added',
			$changes
		);

		$this->assertEquals(
			['1', '2', '3'],
			$changes['Fixes']
		);

		$this->assertEquals(
			['a'],
			$changes['Added']
		);
	}

	public function testFullParse()
	{
		$content = [
			'# Change log',
			'## 1.0.0',
			'### Fixes',
			'- Issue 1',
			'- Issue 2',
			'## 0.4.0',
			'### Adds',
			'- Awesome new feature',
		];

		$log = $this->parser->parse($content);
		$this->assertEquals(
			'Change log',
			$log->getTitle()
		);

		$this->assertTrue(
			$log->hasRelease('1.0.0')
		);
		$this->assertTrue(
			$log->hasRelease('0.4.0')
		);
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

		$actual = $this->parser->render($log);
		$this->assertEquals(
			$expected,
			$actual
		);

	}

}
