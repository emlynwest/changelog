<?php
/**
 * @category Library
 * @license MIT http://opensource.org/licenses/MIT
 * @link https://github.com/emlynwest/changelog
 */

namespace ChangeLog;

/**
 * Standard interface for change log parsers.
 */
interface ParserInterface
{

	/**
	 * Takes the given content and parses it into a populated Log object.
	 *
	 * @param string[] $content
	 *
	 * @return Log
	 */
	public function parse($content);

}
