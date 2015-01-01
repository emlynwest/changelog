<?php
/**
 * PHP Version 5.5
 * @category Library
 * @package ChangeLog
 * @author Steve "uru" West <uruwolf@gmail.com>
 * @license MIT http://opensource.org/licenses/MIT
 * @link https://github.com/stevewest/changelog
 */

namespace ChangeLog\Provider;

use ChangeLog\AbstractProvider;

/**
 * Allows change logs to be loaded from the file system.
 */
class File extends AbstractProvider
{

	/**
	 * Returns the next available line of the change log or null if there is no more
	 * content.
	 *
	 * @return string|null
	 */
	public function nextLine()
	{
		// TODO: Implement nextLine() method.
	}

}
