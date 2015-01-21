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
use Mockery;

/**
 * Tests for ChangeLog
 */
class ChangeLogTest extends Test
{

	public function testParse()
	{
		$content = ['foobar'];
		$provider = Mockery::mock('ChangeLog\IOInterface');
		$provider->shouldReceive('getContent')
			->once()
			->andReturn($content);

		$parser = Mockery::mock('ChangeLog\ParserInterface');
		$parser->shouldReceive('parse')
			->once()
			->with($content);

		(new ChangeLog($provider, $parser))
			->parse();
	}

}
