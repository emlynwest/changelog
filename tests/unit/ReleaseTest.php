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
 * Tests for Release
 */
class ReleaseTest extends Test
{

	/**
	 * @var Release
	 */
	protected $release;

	protected function _before()
	{
		$this->release = new Release;
	}

	public function testGetSetName()
	{
		$name = '1.0.0';
		$this->release->setName($name);
		$this->assertEquals(
			$name,
			$this->release->getName()
		);
	}

	public function testGetSetYanked()
	{
		$this->assertFalse(
			$this->release->isYanked()
		);

		$this->release->setYanked(true);

		$this->assertTrue(
			$this->release->isYanked()
		);
	}

	public function testGetSetLink()
	{
		$link = 'http://google.com';
		$this->release->setLink($link);
		$this->assertEquals(
			$link,
			$this->release->getLink()
		);
	}

	public function testGetSetChanges()
	{
		$fixes = ['#1', '#2', '#3'];
		$changes = [
			'fixed' => $fixes,
			'added' => ['Super awesome feature']
		];

		$this->release->setAllChanges($changes);
		$this->assertEquals(
			$changes,
			$this->release->getAllChanges()
		);

		$this->assertEquals(
			$fixes,
			$this->release->getChanges('fixed')
		);

		$this->assertNull(
			$this->release->getChanges('foobar')
		);

		$this->release->addChange('fixed', '#4');
		$this->assertEquals(
			array_merge($fixes, ['#4']),
			$this->release->getChanges('fixed')
		);

		$this->release->addChange('new', 'foobar');
		$this->assertEquals(
			['foobar'],
			$this->release->getChanges('new')
		);

		$newFixes = ['a'];
		$this->release->setChanges('fixed', $newFixes);
		$this->assertEquals(
			$newFixes,
			$this->release->getChanges('fixed')
		);
	}

}
