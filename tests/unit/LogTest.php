<?php
/**
 * PHP Version 5.6
 * @category Library
 * @package ChangeLog
 * @author Steve "uru" West <steven.david.west@gmail.com>
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

	public function testArrayAccess()
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
			['0.2.0', '0.1.0'],
			$releases
		);
	}

	public function testRevisionsAreStoredInOrder()
	{
		$releases = ['2.0.0', '2.1.0', '1.0.0-rc.1', '3.0.0-beta.1'];
		$expected = ['3.0.0-beta.1', '2.1.0', '2.0.0', '1.0.0-rc.1'];

		foreach ($releases as $releaseName)
		{
			$this->log->addRelease(new Release($releaseName));
		}

		$this->assertEquals(
			$expected,
			array_keys($this->log->getReleases())
		);
	}

	public function testMerge()
	{
		$thisRelease1 = new Release('1.0.0');
		$thisRelease1->setAllChanges([
			'Added' => ['Added 1', 'Added 2'],
			'Changed' => ['Changed 1'],
		]);
		$this->log->addRelease($thisRelease1);

		$thisRelease1 = new Release('2.0.0');
		$this->log->addRelease($thisRelease1);

		$otherLog = new Log;

		$thisRelease3 = new Release('1.0.0');
		$thisRelease3->setAllChanges([
			'Added' => ['Added 3', 'Added 4'],
			'Removed' => ['Removed 1'],
		]);
		$otherLog->addRelease($thisRelease3);

		$thisRelease4 = new Release('3.0.0');
		$otherLog->addRelease($thisRelease4);

		$this->log->mergeLog($otherLog);

		$this->assertTrue($this->log->hasRelease('1.0.0'));
		$this->assertTrue($this->log->hasRelease('2.0.0'));
		$this->assertTrue($this->log->hasRelease('3.0.0'));

		$mergedRelease = $this->log->getRelease('1.0.0');
		$this->assertEquals(
			[
				'Added' => ['Added 1', 'Added 2', 'Added 3', 'Added 4'],
				'Changed' => ['Changed 1'],
				'Removed' => ['Removed 1'],
			],
			$mergedRelease->getAllChanges()
		);
	}

	public function testRemoveRelease()
	{
		$name = '1.0.0';
		$release = new Release($name);
		$this->log->addRelease($release);

		$this->assertTrue(
			$this->log->hasRelease($name)
		);

		$this->log->removeRelease($name);

		$this->assertFalse(
			$this->log->hasRelease($name)
		);
	}

	/**
	 * @link https://github.com/stevewest/changelog/issues/15
	 */
	public function testSortWithUnreleased()
	{
		$release1 = new Release('0.1.0');
		$release2 = new Release('Unreleased');

		$this->log->addRelease($release1);
		$this->log->addRelease($release2);

		$this->assertEquals(
			['unreleased' => $release2, '0.1.0' => $release1],
			$this->log->getReleases()
		);
	}

}
