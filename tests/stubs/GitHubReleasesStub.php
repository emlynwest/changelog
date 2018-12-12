<?php
/**
 * PHP Version 5.6
 * @category Library
 * @package ChangeLog
 * @author Emlyn West <emlyn.west@gmail.gom>
 * @license MIT http://opensource.org/licenses/MIT
 * @link https://github.com/emlynwest/changelog
 */

namespace ChangeLog\Stub;

use ChangeLog\IO\GitHub;
use ChangeLog\IO\GitHubReleases;
use Mockery;

class GitHubReleasesStub extends GitHubReleases
{

	/**
	 * @return \Mockery\Mock
	 */
	public function setApi($api)
	{
		$this->api = $api;
	}

}
