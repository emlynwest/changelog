<?php
/**
 * PHP Version 5.5
 * @category Library
 * @package ChangeLog
 * @author Steve "uru" West <steve.david.west@gmail.com>
 * @license MIT http://opensource.org/licenses/MIT
 * @link https://github.com/stevewest/changelog
 */

namespace ChangeLog;

use Codeception\TestCase\Test;

/**
 * Tests for Log
 */
class LogTest extends Test
{

	/**
	 * @var Log
	 */
	protected $log;

	protected function _before()
	{
		$this->log = new Log;
	}

	public function testGetSetDescription()
	{
		$description = 'A log file that shows changes to the project.';
		$this->log->setDescription($description);
		$this->assertEquals(
			$description,
			$this->log->getDescription()
		);
	}

	public function testGetSetTitle()
	{
		$title = 'My Change Log';
		$this->log->setTitle($title);
		$this->assertEquals(
			$title,
			$this->log->getTitle()
		);
	}

	public function testGetSetRelease()
	{
		$name = '1.0.0';
		$release = new Release;
		$release->setName($name);

		$this->assertFalse(
			$this->log->hasRelease($name)
		);
		$this->assertNull(
			$this->log->getRelease($name)
		);

		$this->log->addRelease($release);
		$this->assertTrue(
			$this->log->hasRelease($name)
		);
		$this->assertEquals(
			$release,
			$this->log->getRelease($name)
		);
		$this->assertEquals(
			[$name => $release],
			$this->log->getReleases()
		);
	}

	public function testArrayAcces()
	{
		$release1 = new Release;
		$release1->setName('0.1.0');
		$release2 = new Release;
		$release2->setName('0.2.0');

		$log = new Log;
		$log->addRelease($release1);
		$log->addRelease($release2);

		$this->assertEquals(
			2,
			count($log)
		);

		$releases = [];
		/** @var Release $release */
		foreach ($log as $release)
		{
			$releases[] = $release->getName();
		}

		$this->assertEquals(
			['0.1.0', '0.2.0'],
			$releases
		);
	}

}
