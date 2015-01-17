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

}
