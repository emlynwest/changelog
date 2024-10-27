<?php
/**
 * @category Library
 * @license MIT http://opensource.org/licenses/MIT
 * @link https://github.com/emlynwest/changelog
 */

namespace ChangeLog\Stub;

use ChangeLog\IO\GitHub;
use Mockery;

class GitHubStub extends GitHub
{

	/**
	 * @return \Mockery\Mock
	 */
	public function setApi($api)
	{
		$this->api = $api;
	}

}
