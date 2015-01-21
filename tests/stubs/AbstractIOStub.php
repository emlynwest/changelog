<?php
/**
 * PHP Version 5.5
 * @category Library
 * @package ChangeLog
 * @author Steve "uru" West <steve.david.west@gmail.com>
 * @license MIT http://opensource.org/licenses/MIT
 * @link https://github.com/stevewest/changelog
 */

namespace ChangeLog\Stub;

use ChangeLog\AbstractIO;

/**
 * Stub class for testing AbstractIO
 */
class AbstractIOStub extends AbstractIO
{

	protected $configDefaults = [
		'default' => 'value',
	];

	/**
	 * {@inheritdoc}
	 */
	public function getContent()
	{
		return null;
	}

}
