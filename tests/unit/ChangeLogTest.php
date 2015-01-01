<?php

namespace ChangeLog;

use Codeception\TestCase\Test;

/**
 * Tests for ChangeLog
 */
class ChangeLogTest extends Test
{

	/**
	 * @var ChangeLog
	 */
	protected $changeLog;

	protected function _before()
	{
		$this->changeLog = new ChangeLog;
	}

	public function testReturnTrue()
	{
		$this->assertTrue(
			$this->changeLog->returnTrue()
		);
	}

}
