<?php
/**
 * PHP Version 5.6
 * @category Library
 * @package ChangeLog
 * @author Steve "uru" West <steve.david.west@gmail.com>
 * @license MIT http://opensource.org/licenses/MIT
 * @link https://github.com/stevewest/changelog
 */

namespace ChangeLog\Renderer;

use ChangeLog\Log;
use ChangeLog\Release;
use Codeception\TestCase\Test;
use DateTime;

/**
 * Tests for Xml
 */
class XmlTest extends Test
{

	/**
	 * @var Json
	 */
	protected $renderer;

	protected function _before()
	{
		$this->renderer = new Xml;
	}

	public function testRender()
	{
		$log = new Log;
		$log->setTitle('Change Log');
		$log->setDescription('A log for changes!');

		$release1 = new Release('1.0.0');
		$release1->setLink('http://fuelphp.com');
		$release1->setAllChanges([
			'Fixed' => ['fixed 1', 'fixed 2'],
			'Changed' => ['changed 1'],
		]);
		$release1->setDate(DateTime::createFromFormat('Y-m-d', '2015-01-29'));
		$log->addRelease($release1);

		$release2 = new Release('0.1.0');
		$release2->setLink('http://google.com');
		$release2->setLinkName('foobar');
		$release2->setDate(DateTime::createFromFormat('Y-m-d', '2015-01-20'));
		$release2->setAllChanges([
			'Changed' => ['changed 2'],
		]);
		$log->addRelease($release2);

		$result = $this->renderer->render($log);
		$this->assertXmlStringEqualsXmlFile(
			__DIR__.'/../../resources/Parser-Xml-testRender.xml',
			$result
		);
	}

}
