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

use ChangeLog\Stub\AbstractProviderStub;
use Codeception\TestCase\Test;

/**
 * Tests for AbstractProvider
 */
class AbstractProviderTest extends Test
{

	/**
	 * @var AbstractProvider
	 */
	protected $provider;

	protected function _before()
	{
		$this->provider = new AbstractProviderStub;
	}

	public function testGetConfig()
	{
		$config = ['foo' => 'bar'];

		$this->provider->setConfig($config);

		$this->assertEquals(
			['foo' => 'bar', 'default' => 'value'],
			$this->provider->getConfig()
		);

		$this->assertEquals(
			'bar',
			$this->provider->getConfig('foo')
		);

		$this->assertEquals(
			'value',
			$this->provider->getConfig('default')
		);

		$this->assertNull(
			$this->provider->getConfig('not here')
		);
	}

	public function testOverrideDefault()
	{
		$config = ['default' => 'new value'];

		$this->provider->setConfig($config);

		$this->assertEquals(
			$config,
			$this->provider->getConfig()
		);
	}

}
