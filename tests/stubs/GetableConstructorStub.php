<?php
/**
 * @category Library
 * @license MIT http://opensource.org/licenses/MIT
 * @link https://github.com/emlynwest/changelog
 */

namespace ChangeLog\Stub;


class GetableConstructorStub
{

	public $one;
	public $two;

	public function __construct($config)
	{
		$this->one = $config[0];
		$this->two = $config[1];
	}

}
