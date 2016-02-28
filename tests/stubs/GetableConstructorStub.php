<?php


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
