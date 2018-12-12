<?php
/**
 * PHP Version 5.6
 * @category Library
 * @package ChangeLog
 * @author Emlyn West <emlyn.west@gmail.gom>
 * @license MIT http://opensource.org/licenses/MIT
 * @link https://github.com/emlynwest/changelog
 */

namespace ChangeLog;

use Codeception\TestCase\Test;
use DateTime;

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

	public function testGetSetDate()
	{
		$date = new DateTime;

		$this->release->setDate($date);
		$this->assertEquals(
			$date,
			$this->release->getDate()
		);
	}

	public function testGetSetLinkName()
	{
		$name = 'abc';

		$this->release->setLinkName($name);
		$this->assertEquals(
			$name,
			$this->release->getLinkName()
		);
	}

}
