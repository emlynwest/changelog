<?php
/**
 * PHP Version 5.6
 * @category Library
 * @package ChangeLog
 * @author Emlyn West <emlyn.west@gmail.gom>
 * @license MIT http://opensource.org/licenses/MIT
 * @link https://github.com/emlynwest/changelog
 */

namespace ChangeLog;

/**
 * Standard interface for change log parsers.
 */
interface RenderInterface
{

	/**
	 * Takes the given log and turns that back into a text change log.
	 *
	 * @param Log $log
	 *
	 * @return string
	 */
	public function render(Log $log);

}
