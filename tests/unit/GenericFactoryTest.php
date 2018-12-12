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

use ChangeLog\Stub\GetableConstructorStub;
use Codeception\TestCase\Test;
use InvalidArgumentException;
use Mockery;

/**
 * Tests for GenericFactory
 */
class GenericFactoryTest extends Test
{

	/**
	 * @var GenericFactory
	 */
	protected $factory;

	protected function _before()
	{
		$this->factory = new GenericFactory('ChangeLog\IO\\');
	}

	public function testGetInstance()
	{
		$this->assertInstanceOf(
			'ChangeLog\IO\Native',
			$this->factory->getInstance('native')
		);
	}

	/**
	 * @expectedException InvalidArgumentException
	 */
	public function testGetInvalidClass()
	{
		$this->factory->getInstance('If this works there is something seriously wrong!');
	}

	public function testCustomClass()
	{
		$class = 'ChangeLog\Stub\AbstractIOStub';
		$name = 'foobar';

		$this->factory->addClass($name, $class);

		$this->assertInstanceOf(
			$class,
			$this->factory->getInstance($name)
		);
	}

	public function testGetInstanceWithParameters()
	{
		$one = 'foo';
		$two = 'bar';

		$class = 'ChangeLog\Stub\GetableConstructorStub';
		$this->factory->addClass('bazbat', $class);

		/** @var GetableConstructorStub $instance */
		$instance = $this->factory->getInstance('bazbat', [$one, $two]);

		$this->assertInstanceOf(
			$class,
			$instance
		);

		$this->assertEquals(
			$one,
			$instance->one
		);

		$this->assertEquals(
			$two,
			$instance->two
		);
	}


}
