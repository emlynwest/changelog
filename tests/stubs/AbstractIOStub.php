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

	/**
	 *{@inheritdoc}
	 */
	public function setContent($content)
	{
	}

}
