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
use LogicException;
use Mockery;

/**
 * Tests for ChangeLog
 */
class ChangeLogTest extends Test
{

	public function testParse()
	{
		$content = ['foobar'];
		$input = Mockery::mock('ChangeLog\IOInterface');
		$input->shouldReceive('getContent')
			->once()
			->andReturn($content);

		$parser = Mockery::mock('ChangeLog\ParserInterface');
		$parser->shouldReceive('parse')
			->once()
			->with($content);

		$changeLog = new ChangeLog;
		$changeLog->setParser($parser);
		$changeLog->setInput($input);
		$changeLog->parse();
	}

	public function testWrite()
	{
		$log = new Log;
		$parsed = 'foobar';

		$renderer = Mockery::mock('ChangeLog\ParserInterface');
		$renderer->shouldReceive('render')
			->once()
			->with($log)
			->andReturn($parsed);

		$output = Mockery::mock('ChangeLog\IOInterface');
		$output->shouldReceive('setContent')
			->once()
			->with($parsed);

		$changeLog = new ChangeLog;
		$changeLog->setRenderer($renderer);
		$changeLog->setOutput($output);
		$changeLog->write($log);
	}

	/**
	 * @expectedException LogicException
	 */
	public function testParseWithoutInput()
	{
		$parser = Mockery::mock('ChangeLog\ParserInterface');
		$changeLog = new ChangeLog($parser);
		$changeLog->parse();
	}

	/**
	 * @expectedException LogicException
	 */
	public function testWriteWithoutInput()
	{
		$parser = Mockery::mock('ChangeLog\RenderInterface');
		$changeLog = new ChangeLog();
		$changeLog->setRenderer($parser);
		$changeLog->write(new Log);
	}

}
