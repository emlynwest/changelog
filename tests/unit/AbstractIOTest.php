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

use ChangeLog\Stub\AbstractIOStub;
use Codeception\TestCase\Test;

/**
 * Tests for AbstractIO
 */
class AbstractIOTest extends Test
{

	/**
	 * @var AbstractIO
	 */
	protected $provider;

	protected function _before()
	{
		$this->provider = new AbstractIOStub;
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
