<?php
/**
 * @category Library
 * @license MIT http://opensource.org/licenses/MIT
 * @link https://github.com/emlynwest/changelog
 */

namespace ChangeLog;

use Codeception\Test\Unit;
use LogicException;
use Mockery;

/**
 * Tests for ChangeLog
 */
class ChangeLogTest extends Unit
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

		$renderer = Mockery::mock('ChangeLog\RenderInterface');
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

	public function testParseWithoutInput()
	{
		$this->expectException(LogicException::class);

		$parser = Mockery::mock('ChangeLog\ParserInterface');
		$changeLog = new ChangeLog($parser);
		$changeLog->parse();
	}

	public function testWriteWithoutInput()
	{
		$this->expectException(LogicException::class);

		$parser = Mockery::mock('ChangeLog\RenderInterface');
		$changeLog = new ChangeLog();
		$changeLog->setRenderer($parser);
		$changeLog->write(new Log);
	}

}
